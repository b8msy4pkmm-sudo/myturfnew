const btnClose=document.querySelectorAll('.btn-alert');
const zoneAlert=document.querySelectorAll('.zone-alert');
for(let i=0;i<zoneAlert.length;i++){
    btnClose[i].addEventListener('click',()=>{
        console.log("je ferme");
        zoneAlert[i].classList.add('display-none');
    })
}

