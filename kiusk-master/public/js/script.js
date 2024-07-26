// function copyKeyword(id) {
//   var span = document.getElementById(id);
//
//   document.execCommand("copy");
//   console.log(span.textContent)
//     console.log(event,'111111111')
//   span.addEventListener("copy", function (event) {
//     event.preventDefault();
//     console.log(event,'222222222')
//     if (event.clipboardData) {
//     console.log(event,'333333333')
//       event.clipboardData.setData("text/plain", span.textContent);
//       // const elementById = document.getElementById('data.seo_description');
//       // elementById.value +=event.clipboardData.getData("text")
//       console.log(event.clipboardData.getData("text"))
//     }
//   });
// }
/*$(document).ready(function () {
  $(".more-content").slice(0, 20).show();
  $(".loadmore").on("click", function (e) {
    e.preventDefault();
    $(".more-content:hidden").slice(0, 8).slideDown();
    if ($(".more-content:hidden").length == 0) {
      $(".loadmore")
        // .text("وجود ندارد")
        .addClass("noContent");
    }
  });
})*/
const span = document.querySelector("#linkPost");
if (span) {
  const elementById = document.getElementById('shortlink');
  span.onclick = function () {
    document.execCommand("copy");
  }
  elementById.onselect = function () {
    document.execCommand("copy");
  }
  span.addEventListener("copy", function (event) {
    event.preventDefault();
    if (event.clipboardData) {
      const elementById = document.getElementById('shortlink');
      elementById.select();
      elementById.setSelectionRange(0, 99999);
      event.clipboardData.setData("text/plain", elementById.value);
      Swal.fire({
        'icon': 'success',
        'title': 'لینک ' + elementById.value + ' با موفقیت کپی شد.',
        'timerProgressBar': true,
        'timer': 2000,
        'confirmButtonText': '<i class="fa fa-thumbs-up"></i> متوجه شدم',
        'width': 300,
      })
      // console.log(event.clipboardData.getData("text"))
    }
});
}
