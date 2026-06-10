const btnEdit           = document.querySelector('#btn-edit');
const btnValue          = document.querySelector('#btn-validation');
const groupFields       = document.querySelectorAll('.group-fields');
const dialogBoxProfil   = document.querySelector('#dialog-box-profil-account');
const inputBox          = document.querySelectorAll('input');
const titleForm         = document.querySelector('.form-title');
const pwdProfil         = document.querySelector('.profil-pwd');
const dialogBoxPwd      = document.querySelector('#dialog-box-pwd-account');
const btnModifyPwd      = document.querySelector('#btn-modify-pwd');
const linkInfo          = document.querySelector('.signMeIn');
const userPicture       = document.querySelector('#userPicture');
const btnUserList       = document.querySelector('#btn-valid-user');
const dialogBoxUserList = document.querySelector('#dialog-box-user-list');
const dialogBoxDelete   = document.querySelector('#dialog-box-delete-account');   
const btnDeleteUser     = document.querySelector('#btn-delete-account'); 
const deleteUserUser    = document.querySelector('#delete-account'); 


if (btnEdit){
    btnEdit.addEventListener("click",()=>{
        dialogBoxProfil.classList.remove('bg-none');
        btnEdit.classList.add('display-none');
        linkInfo.classList.remove('display-none');
        pwdProfil.classList.add('display-none');
        titleForm.classList.remove('title-black');
        btnValue.classList.remove('display-none');
        userPicture.classList.add('display-none');
        for(let i=0;i<groupFields.length;i++){
            groupFields[i].classList.remove('bg-transparent','border-none');
        }
        for(let i=0;i<4;i++){
            inputBox[i].attributes.removeNamedItem('readonly');
            inputBox[i].setAttribute('required','');
        }
    })
}

if(btnValue){
    btnValue.addEventListener("click",()=>{
        btnEdit.classList.remove('display-none');
        btnValue.classList.add('display-none');
        titleForm.classList.add('title-black');
    })
}


if(btnModifyPwd){
    btnModifyPwd.addEventListener("click", ()=>{
        dialogBoxProfil.classList.add('display-none');
        dialogBoxPwd.classList.remove('display-none');
        userPicture.classList.add('display-none');
        btnDeleteUser.classList.add('display-none');
    })

}

if(btnUserList){
    btnUserList.addEventListener("click",()=>{
        dialogBoxUserList.classList.add('display-none');
    })
}

if(btnDeleteUser){
    btnDeleteUser.addEventListener('click',()=>{
        dialogBoxDelete.classList.remove('display-none');
        dialogBoxProfil.classList.add('display-none');
        deleteUserUser.classList.add('display-none');
        userPicture.classList.add('display-none');
    })
}

