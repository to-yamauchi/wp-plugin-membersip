var twrap = document.querySelector(".twrap");
var textarea = twrap.querySelector("textarea");
var dummy = twrap.querySelector("pre code");

resizeTA();

textarea.oninput = function() {
  dummy.innerText = textarea.value + "\u200b";//textareaの値の最後が改行コードだった場合に対応するためのゼロ幅スペース
  hljs.highlightBlock(dummy);
  resizeTA();
}

function resizeTA() {
  dummy.classList.add("resizing");//ありのままの大きさに戻す
  twrap.style.height = (dummy.scrollHeight + 20) + "px";//念の為に20pxほどマージンを取っている
  dummy.classList.remove("resizing");
}