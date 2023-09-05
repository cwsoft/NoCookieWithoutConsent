/**
 * Class NoCookieWithoutConsent implements the logic of the cookie consent dialogue.
 * Adds button click event handler to show/hide cookie consent dialoge as needed and
 * sets the JavaScript Cookie 'nocowoco' to value 'allow_neccessary|decline_neccessary'.
 */
"use strict";

// Create and initialize object NoCookiesWithoutConsent once DOM is ready.
document.addEventListener("DOMContentLoaded", () => new NoCookieWithoutConsent().init());

class NoCookieWithoutConsent {
  divWrapper: HTMLElement | null = null;
  btnCloseIcon: HTMLButtonElement | null = null;
  btnConsent: HTMLButtonElement | null = null;
  btnClose: HTMLButtonElement | null = null;
  btnDecline: HTMLButtonElement | null = null;
  btnElements: HTMLButtonElement[] = [];

  init(): void {
    // Get required HTML elements from DOM.
    this.divWrapper = document.querySelector("#cc-wrapper");
    this.btnCloseIcon = document.querySelector("#cc-close-icon");
    this.btnConsent = document.querySelector("#cc-consent");
    this.btnClose = document.querySelector("#cc-close");
    this.btnDecline = document.querySelector("#cc-decline");

    // Ensure all required HTML elements are defined in the template.
    if (!(this?.divWrapper && this?.btnCloseIcon && this?.btnConsent && this?.btnClose && this?.btnDecline)) {
      console.error(
        "NoCoWoCo: Missing at least one required HTML element: '#cc-wrapper, #cc-close-icon, #cc-consent, #cc-close, #cc-decline'."
      );
      return;
    }

    // Ensure consent dialogue is shown if no 'nocowoco' cookie yet exists.
    if (this.getCookie("nocowoco") === "") {
      this.divWrapper?.classList?.remove("cc-hidden");
    }

    // Add interactive button elements into array for easier processing.
    this.btnElements = [this.btnCloseIcon, this.btnConsent, this.btnClose, this.btnDecline];

    // Register click event handler for all interactive buttons.
    this.btnElements.forEach((element) => {
      element.addEventListener("click", (event: Event) => this.process(event));
    });
  }

  process(event: Event): void {
    // Ensure clicked element is a valid 'nocowoco' button.
    const btnElement = event?.target as HTMLButtonElement;
    if (["cc-close-icon", "cc-consent", "cc-close", "cc-decline"].indexOf(btnElement?.id) < 0) return;

    // Set cookie expiry date to 7 days on consent, expired on close or end of browser session on decline.
    const expireDays = btnElement.id == "cc-consent" ? 7 : btnElement.id.startsWith("cc-close") ? -1 : 0;
    this.setCookie(expireDays);

    // Hide cookie consent dialogue once nocowoco cookie was set.
    this.divWrapper?.classList.add("cc-hidden");

    // Hide cookie consent dialogue and unregister button event listener.
    this.btnElements.forEach((element) => {
      element?.removeEventListener("click", this.process, false);
    });

    // Reload page if consent button was clicked to refresh cookies.
    if (btnElement.id == "cc-consent") {
      location.reload();
    }
  }

  getCookie(cookieName: string): string {
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

  setCookie(expireDays: number = 7): void {
    // Set defaults if user declined cookies.
    let cookieValue = "decline_necessary";
    let expireDate = expireDays < 0 ? "Thu, 01 Jan 1970 00:00:00 UTC" : 0;

    // Update values if user consent cookies.
    if (expireDays > 0) {
      cookieValue = "allow_necessary";
      expireDate = new Date(Date.now() + expireDays * 24 * 60 * 60 * 1000).toUTCString();
    }
    document.cookie = `nocowoco=${cookieValue};expires=${expireDate};path=/;SameSite=Lax`;
  }
}
