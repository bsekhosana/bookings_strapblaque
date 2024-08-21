/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2024 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */(()=>{const t=()=>localStorage.getItem("bs_theme")??"auto",d=()=>t()??"auto",o=e=>{e==="auto"?document.documentElement.setAttribute("data-bs-theme",window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light"):document.documentElement.setAttribute("data-bs-theme",e)};window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change",()=>{const e=t();e!=="light"&&e!=="dark"&&o(d())}),window.addEventListener("DOMContentLoaded",()=>{o(d())})})();
