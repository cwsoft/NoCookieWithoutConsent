# NoCookieWithoutConsent

[ProcessWire](https://processwire.com) module to disable the ProcessWire frontend cookie `wire` until user gave his consent.

Module hooks before `page::render` to show a cookie consent dialogue consenting the user allowing technical required cookies. User can accept or decline using technical required cookies. The module sets `$config->sessionAllow=true` if a wire cookie already exists, the requested Url contains an admin path or the user gave consent using required cookies. This way frontend users can control if the ProcessWire cookie `wire` will be set or not.

The consent cookie (nocowoco) is stored for 7 days if user gave consent in order to hide the cookie dialogue on subsequent visits unless the cookie is deleted by the user or the browser. If the user declined using cookies, the preference is stored in the cookie nocowoco till the end of the browser session. This ensures the cookie dialogue stays hidden for the actual session, but will show up again on subsequent website visits after the browser was closed.

## Installation

Download latest module zip file via [Download button](https://processwire.com/modules/no-cookie-without-consent/) of the ProcessWire module page or from [Github release section](https://github.com/cwsoft/NoCookieWithoutConsent/releases) and unzip it to your site/modules folder. Ensure the module folder is named **NoCookieWithoutConsent**. Alternatively you can clone the repository into your Processwire site/modules folder (recommended way for developers) via the following commands:

```
cd /your_processwire_folder/site/modules
git clone https://github.com/cwsoft/NoCookieWithoutConsent.git
```

Once the module files are copied in place, login to your ProcessWire backend and reload the modules. Afterwards the **NoCookieWithoutConsent** module should show up in your backend ready to be installed by ProcessWire as usual. Once installed, log out of the backend, clear browser cookies and view a page to see the cookie consent dialogue in action.

## Customization

### Style Cookie Consent Dialogue

You can style the Cookie Consent Dialogue by adapting the template file `CookieConsentDialogue.tpl.php` and the corresponding CSS and Javascript files. If you want to show links to your imprint and privacy policy page, specify the corresponding Url segments in the module backend. By default no links to imprint and policy pages are shown unless you specify them yourself. You can specify if you want to render the optional buttons 'Decline' and 'Close' in the cookie dialogue via a dropdown menu in the module backend.

### Language files

By default this module ships with an English and German language file. If you want to add another language, please follow the translation steps described in the [Helloworld module](https://processwire.com/modules/helloworld/) by Ryan Cramer.

Apart from the styling of the cookie consent dialogue, providing links to your imprint and privacy policy pages and the option to render the optional buttons 'Decline' and 'Close' via the module backend, no further customizations are yet available. Idea was to keep this module as clean and lean as possible. If you need additional features or want to customize stuff to your needs, you may want to check out other Cookie modules available in the official [ProcessWire modules catalog](https://processwire.com/search/?q=cookie&t=Modules).

Have fun
cwsoft
