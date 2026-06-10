function show() {
    document.querySelector(".container.loader").classList.remove('.disappear');
    document.querySelector(".container.loader").classList.add('.appear');
}

function hide(){
    document.querySelector(".container.loader").classList.add('.disappear');
    document.querySelector(".container.loader").classList.remove('.appear');
    setTimeout(hide,'3000');
}

