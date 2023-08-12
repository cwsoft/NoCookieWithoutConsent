# NoCookieWithoutConsent

[ProcessWire](https://processwire.com) module to disable ProcessWire frontend cookie (wire) until user gave consent.

Module hooks before `page::render` and adds a cookie consent dialogue consenting for technical required cookies. User can consent or decline using technical required cookies. The module sets `$config->sessionAllow=true` if a wire cookie already exists, the requested Url contains an admin path or the user gave consent using required cookies. This way frontend users can control if the ProcessWire cookie `wire` is set or not.

The consent cookie (nocowoco) is stored for 7 days if user gave consent in order to hide the cookie dialogue on subsequent visits unless the user or browser deletes the cookie. If user declined using cookies, the preference is stored in the cookie nocowoco till the browser session ends. This ensures the cookie dialogue stays hidden for the actual session, but shows up again on subsequent website visits after browser was closed. 

## Installation

Download Zip file from [Releases section](https://github.com/cwsoft/NoCookieWithoutConsent/releases) to your site/modules, unzip it and rename the module folder into **NoCookieWithoutConsent**. Alternatively you can clone the repository into your Processwire site/modules folder (recommended) via the following commands:

```
cd /your_processwire_folder/site/modules
git clone https://github.com/cwsoft/NoCookieWithoutConsent.git ./NoCookieWithoutConsent
```

Once the module files are copied in place, login to your ProcessWire backend and reload the modules. Afterwards the **NoCookieWithoutContent** module should show up in your backend ready to be installed by ProcessWire as usual. Once installed, log out of the backend, clear browser cookies and view a page to see the cookie consent dialogue in action.

## Customization

### Style Cookie Consent Dialogue

You can style the Cookie Consent Dialogue by adapting the template file `CookieConsentDialogue.tpl.php` and the corresponding CSS and Javascript files. If you want to show links to your imprint and privacy policy page, specify the pathes at the top of the template file. The default values are shown below.

```PHP
$imprintUrl = pages()->findOne('impressum')->url;
$privacyPolicyUrl = pages()->findOne('datenschutz')->url;
```

### Language files

By default this module ships with an English and German language files. If you want to add another language, please follow the translation steps described in the [Helloworld module](https://processwire.com/modules/helloworld/) by Ryan Cramer.

Apart from the styling of the cookie consent dialogue and the links to imprint and privacy policy pages, no further customizations are yet available. Idea was to keep this module as clean and lean as possible. If you need additional features or want to customize stuff to your needs, you may want to check out other Cookie modules available in the official [ProcessWire modules catalog](https://processwire.com/search/?q=cookie&t=Modules).

Have fun
cwsoft
