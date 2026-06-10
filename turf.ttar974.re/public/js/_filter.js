const allHippos           = document.querySelectorAll('.li-hippodromes input');
const selectHippos     = document.querySelector('#toggleSelectedHippodromes_0');
const allTipsters         = document.querySelectorAll('.li-tipsters input');
const selectTipsters      = document.querySelector('#toggleSelectedTipsters_0');
const trackLengthSelected = document.querySelector('#toggleSelectedTrackLength_0');
const minLength =document.querySelector('#min_length');
const maxLength =document.querySelector('#max_length');
const viewMinLength = document.querySelector('#length_min');
const viewMaxLength = document.querySelector('#length_max');
const toggleFilter  = document.querySelector('.toggleFilter');
const btnViewFilter = document.querySelector('#btnViewFilter'); 
const btnMaskFilter = document.querySelector('#btnMaskFilter'); 
const resetFilter = document.querySelector('#resetFilter'); 
const btnValidFilter = document.querySelector('#btn-valid-filter'); 


if(selectHippos){
    selectHippos.addEventListener('click',()=>{
        for (let index = 0; index < allHippos.length; index++) {
            if(allHippos[index].attributes.getNamedItem('checked')){
                allHippos[index].attributes.removeNamedItem('checked');
            }else{
                allHippos[index].setAttribute('checked','');
            }
        }
    })
}
if(selectTipsters){
    selectTipsters.addEventListener('click',()=>{
        for (let index = 0; index < allTipsters.length; index++) {
            if(allTipsters[index].attributes.getNamedItem('checked')){
                allTipsters[index].attributes.removeNamedItem('checked');
            }else{
                allTipsters[index].setAttribute('checked','');
            }
        }
    })
}

if(trackLengthSelected){
    trackLengthSelected.addEventListener('click',()=>{
         
        if (minLength.attributes.getNamedItem('readonly')) {
            minLength.attributes.removeNamedItem('readonly');
""        }else{
            minLength.setAttribute('readonly','');
            minLength.classList.add('bg-none');
        }
        if (maxLength.attributes.getNamedItem('readonly')) {
            maxLength.attributes.removeNamedItem('readonly');
        }else{
            maxLength.setAttribute('readonly','');
        }
        viewMinLength.classList.toggle('bg-none');
        viewMaxLength.classList.toggle('bg-none');
        viewMinLength.classList.toggle('border-none');
        viewMaxLength.classList.toggle('border-none');
    })
}

if(btnViewFilter){
    btnViewFilter.addEventListener('click',()=>{
        toggleFilter.classList.toggle('display-none');
        btnMaskFilter.classList.toggle('display-none');
        btnViewFilter.classList.toggle('display-none');
        resetFilter.classList.toggle('display-none')
        // btnViewFilter.classList.add('display-none');
    })
}

if(btnMaskFilter){
    btnMaskFilter.addEventListener('click',()=>{
        toggleFilter.classList.toggle('display-none');
        btnViewFilter.classList.toggle('display-none');
        btnMaskFilter.classList.toggle('display-none');
        resetFilter.classList.toggle('display-none');
        // btnMaskFilter.classList.add('display-none');
    })
}

if(resetFilter){
    resetFilter.addEventListener('click',()=>{
        btnViewFilter.classList.toggle('display-none');
    })
}

// if(btnValidFilter){
//     btnValidFilter.addEventListener('click',()=>{
//         btnViewFilter.classList.remove("display-none");
//         btnMaskFilter.classList.add("display-none");

//     })
// }
