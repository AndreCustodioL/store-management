const deleteProductModal = document.getElementById('deleteProductModal')
if (deleteProductModal) {
  deleteProductModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-product-name')
    const uuid = button.getAttribute('data-bs-product-uuid')

    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalBodyProductName = deleteProductModal.querySelector('#recipient-name')

    const modalDeleteButton = deleteProductModal.querySelector('#modalDeleteButton')
    const currentHrefModalDeleteButton = modalDeleteButton.getAttribute('href')

    const newHref = currentHrefModalDeleteButton.replace('{uuid}', uuid)
    modalDeleteButton.setAttribute('href',newHref)
    modalBodyProductName.textContent = `Tem certeza que deseja excluir o produto: "${recipient}"?`
  })
}