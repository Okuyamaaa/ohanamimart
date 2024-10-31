// お気に入りの解除用フォーム
const deleteSaleForm = document.forms.deleteSaleForm;

// 解除の確認メッセージ
const deleteMessage = document.getElementById('deleteSaleModalLabel');

// お気に入りの解除用モーダルを開くときの処理
document.getElementById('deleteSaleModal').addEventListener('show.bs.modal', (event) => {
    let deleteButton = event.relatedTarget;
    let restaurantId = deleteButton.dataset.restaurantId;
    let restaurantName = deleteButton.dataset.restaurantName;

    deleteSaleForm.action = `product/${restaurantId}`;
    deleteMessage.textContent = `「${restaurantName}」を削除してもよろしいですか？`
});

