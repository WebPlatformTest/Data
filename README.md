<img src="https://html5te.st/assets/html5test.svg" width="250">

The HTML5test.com website contains data about other browsers. You can use this data to see the best scoring browsers, 
compare browsers or features and see a timeline of changes for a certain browser. The data that is used for these 
features is stored in this repository and automatically uploaded to the website.

The data is stored in three files:

- `data/variants.json`
- `data/versions.json`
- `data/identifiers.json`

You are welcome to submit pull requests for new browsers and platforms.

Some rules:
- Always use the default settings of the browser. No experimental features enabled.
- Set the `importance` property of new variants always to 0 by default.
- Set the `listed` propery of versions of new variants always to 0 by default.
- In case of a new version, please do not forget to set the status of the previous version to `legacy`.


###Variants

Contains the lowest level data about browsers or platforms. It does not contain information about versions. 
In general this file should not be edited unless you want to add a whole new browser or platform.

````
[
    {
        "id": "chrome",
        "name": "Chrome",
        "grouped": "Chrome",
        "importance": 8,
        "type": "desktop"
    },
    {
        "id": "chrome.mobile",
        "name": "Chrome for Android",
        "grouped": "Chrome",
        "importance": 1,
        "type": "mobile,tablet"
    }
]
````

- `id`: The id of this variant, must be unique, contain only lowercase a-z and dots.
- `name`: The full name of this browser, platform or operating system.
- `grouped`: A simplified name that can be shared between multiple variants.
- `importance`: An integer that determines the sorting of the overview of the 'Other browsers' page. A value of `0` means the item is not visible in the overview.
- `type`: What kind of browser or device this is. Can be a comma seperated list with the following values: `desktop`, `mobile`, `tablet`.


###Versions

Contains the data about individual versions of variants. For every release a new entry should be added. In general, 
existing data should never be deleted, only new data added.


````
[
    {
        "variant": "firefox",
        "version": "38",
        "nickname": "Firefox 38",
        "release": "2015-05-12",
        "type": "desktop",
        "status": "legacy",
        "listed": 0
    }
]
````

- `variant`: The id of this variant, must be unique, contain only lowercase a-z and dots.
- `version`: The version. Try to be as brief as possible, so not 38.0.1, but just 38.
- `nickname`: The name of this browser, including the version.
- `release`: The data on which this version browser was released. Do not use the date of bugfix release, only the date of major releases.
- `type`: What kind of browser or device this is. Can be a comma seperated list with the following values: `desktop`, `mobile`, `tablet`, `ereader`, `television`, `television-box`, `television-smart`, `gaming`, `gaming-portable`, `gaming-console`. A value with a dash (`-`) should always also include the portion before the dash seperately, so `gaming-console` should also include `gaming`, for example: `gaming,gaming-console`.
- `status`: Is this the `current` version, or a `legacy` version or `development` build?
- `listed`: A value of `0` is not listed by default, a value of `1` is listed by default.


###Identifiers

This file contains the actual information that links variants and versions to test results. This file does not have to contain an 
entry for every single item in the `variants.json` and `versions.json` file. However, if you add a new variant or version, also add the 
a unique id for a test result in the `identifiers.json` file.

````
[
    {
        "variant": "safari",
        "version": "9.0",
        "uniqueid": "6293a82fceda7a2c"
    },
    {
        "variant": "safari",
        "version": "9.1",
        "source": "browserstack",
        "identifier": "safari-9.1|OS X-El Capitan"
    }
]
````

- `variant`: The id of this variant.
- `version`: The version as specified in the `versions.json` file.

And either:
- `uniqueid`: The unique id of a test report from the actual website. Open the website, click on 'Save results' and copy and paste the unique id.

Or:
- `source`: In case you want to use an automated browserstack result, the value should always be `browserstack`.
- `identifier`: The identifier of the browserstack generated result as shown by the output of the [WebPlatformTest/Automation](https://github.com/WebPlatformTest/Automation) tool.





