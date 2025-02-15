console.log("hello from the js file");


let user_icon = document.querySelector('.user-icon');
let drop_down = document.querySelector('.user-dropdown');

user_icon.addEventListener("click", (e)=>{
    drop_down.classList.toggle('active');
    e.stopPropagation();
    
})
document.addEventListener("click", (e)=>{
    if(e.target.contains(drop_down)){
        drop_down.classList.remove('active');
    }

})
