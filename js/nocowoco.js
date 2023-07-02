"use strict";
document.addEventListener("DOMContentLoaded", () => new NoCookieWithoutConsent().init());
class NoCookieWithoutConsent {
  divWrapper = null;
  btnConsent = null;
  btnDecline = null;
  init() {
    this.divWrapper = document.querySelector("#cc-wrapper");
    this.btnConsent = document.querySelector("#cc-consent");
    this.btnDecline = document.querySelector("#cc-decline");
    if (!(this?.divWrapper && this?.btnConsent && this?.btnDecline)) {
      console.error("NoCoWoCo: Missing at least one required HTML element: '#cc-wrapper, #cc-consent, #cc-decline'.");
      return;
    }
    if (this.getCookie("nocowoco") === "") {
      this.divWrapper?.classList?.remove("cc-hidden");
    }
    this.btnConsent?.addEventListener("click", (event) => {
      this.process(event);
      setTimeout(() => {
        location.reload();
      }, 500);
    });
    this.btnDecline?.addEventListener("click", (event) => this.process(event));
  }
  process(event) {
    const btnElement = event?.target;
    if (btnElement?.id !== "cc-consent" && btnElement?.id !== "cc-decline") return;
    const expireDays = btnElement.id == "cc-consent" ? 7 : 0;
    this.setCookie(expireDays);
    this.divWrapper?.classList.add("cc-hidden");
    this.btnConsent?.removeEventListener("click", this.process, false);
    this.btnDecline?.removeEventListener("click", this.process, false);
  }
  getCookie(cookieName) {
    const cookieId = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
      let cookie = cookies[i];
      while (cookie.charAt(0) == " ") {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(cookieId) == 0) {
        return cookie.substring(cookieId.length, cookie.length);
      }
    }
    return "";
  }
  setCookie(expireDays = 7) {
    let cookieValue = "decline_necessary";
    let expireDate = "Thu, 01 Jan 1970 00:00:00 UTC";
    if (expireDays > 0) {
      cookieValue = "allow_necessary";
      expireDate = new Date(Date.now() + expireDays * 24 * 60 * 60 * 1000).toUTCString();
    }
    document.cookie = `nocowoco=${cookieValue};expires=${expireDate};path=/;SameSite=Lax`;
  }
}
