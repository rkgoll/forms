var xhr = new XMLHttpRequest();
xhr.open("GET", "http://localhost/", false);
xhr.send();

console.log(xhr.status);
console.log(xhr.statusText);