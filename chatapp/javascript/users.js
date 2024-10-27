const searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
usersList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
};

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;//pinapasa ung kinukuhang value 

    if(searchTerm !== "" ){
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/search_function.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }  
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm="+searchTerm);
};

setInterval(() => {
      //ajax time
      let xhr = new XMLHttpRequest();//creating xml object
      xhr.open("GET", "includes/users_function.php", true);
      xhr.onload = () => {
          if(xhr.readyState === XMLHttpRequest.DONE) {
              if(xhr.status === 200) {
                  let data = xhr.response;
                  if(!searchBar.classList.contains("active")) {
                     usersList.innerHTML = data;//if active active not contains in search bar then add this data
                  }
              }
          }
      }  
      xhr.send(); 
}, 500); //mag run lang after 500ms