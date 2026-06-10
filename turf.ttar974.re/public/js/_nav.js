const menuItem = document.querySelectorAll('.menu-item');
const ssmenu   = document.querySelector('.ssmenu');
const dropdownMenu = document.querySelectorAll('.dropdown');
const dropdownMenuItems =document.querySelectorAll('.dropdown-menu');

for(let i=0;i<dropdownMenu.length;i++){
    dropdownMenu[i].addEventListener('click',()=>{
        if(dropdownMenuItems[i].classList.contains('display-none')){
            dropdownMenuItems[i].classList.remove('display-none');
            console.log("j'active sous le menu : "+i);
            for (let j=0;j<dropdownMenu.length;j++){
                if(i!=j && !dropdownMenuItems[j].classList.contains('display-none')){
                    dropdownMenuItems[j].classList.add('display-none');
                }
            }
        }
        else{
            dropdownMenuItems[i].classList.add('display-none');
            console.log("je désactive sous le menu : "+i);
        }
    })
}

// window.addEventListener('click',()=>{
//     for (let j=0;j<dropdownMenu.length;j++){
//         if(!dropdownMenuItems[j].classList.contains('display-none')){
//             dropdownMenuItems[j].classList.add('display-none');
//             console.log(j+ " ne contient pas contient display-none");
//         }
//     }
//     console.log('je clique');
// })