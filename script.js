let a = true;
document.getElementById("changelang").addEventListener("click",function(){

if(a){
    document.getElementById("dropdown-menu").style.display = "flex";
    a = false;

}
else{
    document.getElementById("dropdown-menu").style.display = "none";
    a = true;
}
});

document.getElementById("changelang").addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("dropdown-menu").style.display = "flex";
});
