let a = true;
document.getElementById("dropdown-toggle").addEventListener("click",function(){

if(a){
    document.getElementById("dropdown-menu").style.display = "flex";
    a = false;

}
else{
    document.getElementById("dropdown-menu").style.display = "none";
    a = true;
}
});

