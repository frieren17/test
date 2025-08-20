import './bootstrap';

$(document).ready(function() {
    console.log('メッセージ');
    $("#searchForm").on("submit", function(event) {
        event.preventDefault(); // 通常のフォーム送信を防ぐ

        const formData = $(this).serialize(); // フォームデータを取得

        console.log('リクエスト開始');

        $.ajax({
            url: "products", // ルートに基づく検索APIのエンドポイント
            method: "GET", // GETリクエストを送信
            data: formData,
            dataType: "json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // これを追加
            },
            success: function(response) {
                console.log('レスポンス受信:', response);
                $("#productTableBody").empty(); // 以前の検索結果をクリア

                if (response.length > 0) {
                    response.forEach(function(product) {
                        console.log(product.img_path);

                        const imageTag = product.img_path
                        ? `<img src="${product.img_path}" alt="Product Image" style="max-width: 200px; max-height: 200px;">`
                        : '商品画像';

                        const csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $("#productTableBody").append(`
                            <tr>
                                <td>${product.id}</td>
                                <td>${imageTag}</td>
                                <td>${product.product_name}</td>
                                <td>￥${product.price}</td>
                                <td>${product.stock}</td>
                                <td>${product.company_name}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="location.href='/product/detail/${product.id}'">詳細</button>
                                </td>
                                
                                <td>
                                    <button type="button" class="btn btn-danger delete-button" data-id="${product.id}">削除</button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $("#productTableBody").append(`
                        <tr>
                            <td colspan="8">該当する商品はありません。</td>
                        </tr>
                    `);
                }
                $(".tablesorter").trigger("update");
            },
            error: function(error) {
                console.error("検索に失敗しました:", error);
            }
        });

        console.log('リクエスト送信後の処理');
        // $('.tablesorter').trigger('update');
        // $('.tablesorter').trigger('sortReset');

    });

    //function bindDeleteButtons() {
    $(document).on('click', '.delete-button', function () {
        console.log('削除ボタンがクリックされました');
        const productId = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const row = $(this).closest('tr');

        if (!confirm('本当に削除しますか？')) return;

        $.ajax({
            //url: `${window.location.origin}/test/public/destroy/${productId}`,
            //url: `/product/delete/${productId}`,
            url: `destroy/${productId}`,
            //method: 'DELETE',
            method: 'POST',  // ← 本当はPOSTで送る
            data: {
                _method: 'DELETE'  // ← Laravelがこれを見てDELETEとして扱う
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function () {
                row.remove(); // DOMから該当行を削除
                console.log(`商品ID ${productId} を削除しました`);
            },
            error: function (error) {
                console.error('削除に失敗しました:', error);
                alert('削除に失敗しました。');
            }
        });
    });
    

    // $(document).ready(function(){
    //     bindDeleteButtons();
    $(".tablesorter").tablesorter({
        textExtraction: function(node){
            const attr = $(node).attr('data-value');
            // if(typeof attr !== 'undefined' && attr !== false){
            //     return attr;
            // }
            // return $(node).text();
            return (typeof attr !== 'undefined' && attr !== false) ? attr : $(node).text();
        }
    });
//     }); 
});