function logo() {
  $("[href=\"https://filamentadmin.com\"]").attr('href', 'https://razzar.ir').html('<img class="logo" src="/../../images/razzar.png">')
}

logo();
document.addEventListener("DOMContentLoaded", () => {
  Livewire.hook('message.received', (message, component) => {
    setTimeout(() => {
      logo();
    }, 0.000001);
  })
});

function copyKeyword(id) {
  var span = document.getElementById(id);
  document.execCommand("copy");
  span.addEventListener("copy", function (event) {
    event.preventDefault();
    if (event.clipboardData) {
      event.clipboardData.setData("text/plain", span.textContent);
      // const elementById = document.getElementById('data.seo_description');
      // elementById.value +=event.clipboardData.getData("text")
      // console.log(event.clipboardData.getData("text"))
    }
  });
}
