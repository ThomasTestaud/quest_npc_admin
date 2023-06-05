let editPenNPC = document.querySelectorAll('.edit-NPC-pen');
let editFormNPC = document.querySelectorAll('.edit-NPC-form');
let closeEditNPC = document.querySelectorAll('.close-edit-NPC');

editPenNPC.forEach((pen, index) => {
    pen.addEventListener('click', () => {
        editFormNPC[index].classList.remove('none');
    });
});
closeEditNPC.forEach((pen, index) => {
    pen.addEventListener('click', () => {
        editFormNPC[index].classList.add('none');
    });
});