$(document).ready(() => {
  document.querySelector("#btn-back").addEventListener("click", event => {
      event.preventDefault();
      window.location.href = document.querySelector("input[name=_url_back]").value;
  });
});
