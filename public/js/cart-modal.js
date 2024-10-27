// お気に入りの解除用フォーム
const deleteCartForm = document.forms.deleteCartForm;

// 解除の確認メッセージ
const deleteMessage = document.getElementById('deleteCartModalLabel');

// お気に入りの解除用モーダルを開くときの処理
document.getElementById('deleteCartModal').addEventListener('show.bs.modal', (event) => {
    let deleteButton = event.relatedTarget;
    let restaurantId = deleteButton.dataset.restaurantId;
    let restaurantName = deleteButton.dataset.restaurantName;

    deleteCartForm.action = `cart/`;
    deleteMessage.textContent = `「${restaurantName}」をカートから削除してもよろしいですか？`
});

// // レビューの削除用フォーム
// const deleteReviewForm = document.forms.deleteReviewForm;

// // レビューの削除用モーダルを開くときの処理
// document.getElementById('deleteReviewModal').addEventListener('show.bs.modal', (event) => {
//     let deleteButton = event.relatedTarget;
//     let reviewId = deleteButton.dataset.reviewId;

//     deleteReviewForm.action = `reviews/${reviewId}`;
// });