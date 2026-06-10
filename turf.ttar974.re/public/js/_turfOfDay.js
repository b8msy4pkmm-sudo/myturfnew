const racingWinning_table = document.querySelector('.turfOfDay-table-winnings');
const turfOfDay_result_img= document.querySelector('.turfOfDay-result_img');
const btn_tips=document.querySelector("#btn-tips");
const select_tipster=document.querySelector("#tipster")
const forecasts=document.querySelector("#forecasts");

turfOfDay_result_img.addEventListener("click",()=>{
    console.log("je clique");
    racingWinning_table.classList.toggle('display-none');
})

// if(select_tipster){
//     function showTips() {
//         forecasts.classList.remove('display-none');
//         // document.getElementById("div1").style.visibility = "visible";
//       }
//       setTimeout("showTips()", 1000);
// }




if(select_tipster){
    select_tipster.addEventListener('click',()=>{
        forecasts.classList.add('display-none');  
        btn_tips.classList.add('display-none');
    })
    function showTips() {
        forecasts.classList.remove('display-none');  
      }
       setTimeout("showTips()", 500);
}

// if(btn_tips){
//     function showBtn() {
//         btn_tips.classList.remove('display-none');
//         // document.getElementById("div1").style.visibility = "visible";
//       }
//       setTimeout("showBtn()", 1000);
// }
//window.onload = setTimeout(btn_tips.classList.remove('display-none'), 1500);
