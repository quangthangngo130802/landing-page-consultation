const columns = [

    {
        data: "title",
        name: "title",
        title: "TÊN BÀI VIẾT",
        // render(data, type, row) {
        //     return `<a href="/admin/posts/${row.id}/edit"><strong>${data}</strong></a>`
        // },
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "address",
        name: "address",
        title: "Địa chỉ",
        orderable: false,
        searchable: false,
    },
    {
        data: "types",
        name: "type",
        title: "Loại bài viết",
    },
    {
        data: "statuss",
        name: "status",
        title: "Trạng thái",
    },
];
