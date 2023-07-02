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
  btnConsent: HTMLButtonElement | null = null;
  btnDecline: HTMLButtonElement | null = null;

  init(): void {
    // Get required HTML DOM elements.
    this.divWrapper = document.querySelector("#cc-wrapper");
    this.btnConsent = document.querySelector("#cc-consent");
    this.btnDecline = document.querySelector("#cc-decline");

    // Stop processing if a required HTML element is missing.
    if (!(this?.divWrapper && this?.btnConsent && this?.btnDecline)) {
      console.error("NoCoWoCo: Missing at least one required HTML element: '#cc-wrapper, #cc-consent, #cc-decline'.");
      return;
    }

    // Display consent dialogue if no 'nocowoco' cookie yet exists.
    if (this.getCookie("nocowoco") === "") {
      this.divWrapper?.classList?.remove("cc-hidden");
    }

    // Register consent button click handler.
    this.btnConsent?.addEventListener("click", (event: Event) => {
      this.process(event);
      // Reload page after consent was given so Cookie gets recognized.
      setTimeout(() => {
        location.reload();
      }, 500);
    });

    // Register decline button click handler.
    this.btnDecline?.addEventListener("click", (event: Event) => this.process(event));
  }

  process(event: Event): void {
    // Ensure clicked element is a valid 'nocowoco' button.
    const btnElement = event?.target as HTMLButtonElement;
    if (btnElement?.id !== "cc-consent" && btnElement?.id !== "cc-decline") return;

    // Set cookie expiry date to 7 days on consent, or end of browser session on decline.
    const expireDays = btnElement.id == "cc-consent" ? 7 : 0;
    this.setCookie(expireDays);

    // Hide cookie consent dialogue and unregister button event listener.
    this.divWrapper?.classList.add("cc-hidden");
    this.btnConsent?.removeEventListener("click", this.process, false);
    this.btnDecline?.removeEventListener("click", this.process, false);
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
    let expireDate = "Thu, 01 Jan 1970 00:00:00 UTC";

    // Update values if user consent cookies.
    if (expireDays > 0) {
      cookieValue = "allow_necessary";
      expireDate = new Date(Date.now() + expireDays * 24 * 60 * 60 * 1000).toUTCString();
    }
    document.cookie = `nocowoco=${cookieValue};expires=${expireDate};path=/;SameSite=Lax`;
  }
}
