<?php

namespace App\RankmathSEOForLaravel\Suggestions;

use App\RankmathSEOForLaravel\Suggestions\SuggestionInterface;

class KeywordDensitySuggestion implements SuggestionInterface
{
    public function check(string $seoTitle, string $content, $focusKeyword, string $seoDescription, string $slug): array
    {
        $content = html_entity_decode($content);
        $content = strip_tags($content);
        $content = preg_replace('/[^\p{L}\p{N}\s]+/u', '', $content);
        $contentLower = mb_strtolower($content);

        $wordsArray = preg_split('/\s+/u', $content);
        $totalWords = count($wordsArray);

        // ✨ Nếu là chuỗi JSON thì decode thành mảng
        if (is_string($focusKeyword)) {
            $decoded = json_decode($focusKeyword, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $focusKeyword = $decoded;
            } else {
                $focusKeyword = [['value' => $focusKeyword]]; // fallback thành mảng có 1 value
            }
        }

        // ✅ Lấy giá trị từ khóa từ key 'value' nếu có
        $focusKeywordString = '';
        if (is_array($focusKeyword) && isset($focusKeyword[0]['value'])) {
            $focusKeywordString = $focusKeyword[0]['value'];
        } elseif (is_array($focusKeyword) && isset($focusKeyword[0]) && is_string($focusKeyword[0])) {
            $focusKeywordString = $focusKeyword[0];
        } elseif (is_string($focusKeyword)) {
            $focusKeywordString = $focusKeyword;
        }

        if (empty($focusKeywordString) || $totalWords === 0) {
            return [
                'rule' => 'keyword_density',
                'passed' => false,
                'message' => 'Từ khóa hoặc nội dung không hợp lệ để tính mật độ từ khóa.',
                'score' => 0,
                'suggestion' => 'Vui lòng cung cấp từ khóa và nội dung hợp lệ.',
                'status' => 'danger',
            ];
        }

        $pattern = '/' . preg_quote(mb_strtolower($focusKeywordString), '/') . '/u';
        preg_match_all($pattern, $contentLower, $matches);
        $keywordCount = count($matches[0]);

        $density = ($keywordCount / $totalWords) * 100;
        $isOptimal = $density >= 0.5 && $density <= 2.5;

        $message = $isOptimal
            ? "Mật độ từ khóa tối ưu (" . rtrim(rtrim(number_format($density, 2), '0'), '.') . "%)"
            : "Mật độ từ khóa " . rtrim(rtrim(number_format($density, 2), '0'), '.') . "% (nên từ 0.5% đến 2.5%)";

        return [
            'rule' => 'keyword_density',
            'passed' => $isOptimal,
            'message' => $message,
            'score' => $isOptimal ? 10 : 0,
            'suggestion' => !$isOptimal
                ? ($density < 0.5 ? 'Tăng số lần xuất hiện từ khóa' : 'Giảm số lần xuất hiện từ khóa')
                : '',
            'status' => $isOptimal ? 'success' : 'danger',
        ];
    }
}
