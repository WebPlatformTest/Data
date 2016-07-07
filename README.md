<img src="https://html5te.st/assets/html5test.svg" width="250">

####Important: this feature is still in development and not synced to the main website. If you want to submit results, please use the http://alpha.html5test.com website.

The HTML5test.com website contains data about other browsers. You can use this data to see the best scoring browsers,
compare browsers or features and see a timeline of changes for a certain browser. The data that is used for these
features is stored in this repository and automatically uploaded to the website.

The data is stored in three files:

- `data/platforms.json`
- `data/versions.json`
- `data/tests.json`

You are welcome to submit pull requests for new tests, versions and platforms.

Some rules:
- When testing `legacy`, `current` or `upcoming` versions, always use the default settings of the browser. No experimental features enabled.
- If you want to include an build with experimental features, set the `status` of the version to `experimental` and set the `version` to `null`.
- Set the `order` property of new platforms always to 0 by default.
- Set the `visible` propery of versions of new platforms always to `false` by default.
- In case of a new version, please do not forget to set the status of the previous version to `legacy`.


###Platforms

Contains the lowest level data about platforms. A platform is either a browsers, an operating system or a device.
It does not contain information about versions.
In general this file should not be edited unless you want to add a whole new browser, os or device.

````
[
    {
        "platform": "chrome",
        "name": "Chrome",
        "order": 8,
        "type": "desktop"
    },
    {
        "platform": "chrome.mobile",
        "name": "Chrome for Android",
        "order": 1,
        "type": "mobile,tablet"
    }
]
````

- `platform`: The id of this browser, operating system or device, must be unique, contain only lowercase a-z, 0-9 and dots.
- `name`: The full name of this browser, operating system or device.
- `related`: The id of another entry in this file which is related to this entry. This should be used to add to old platforms and point to the latest incarnation of that platform. For example, the Xbox 360 should point to the Xbox One, but not the other way around. If there are multiple older incarnations, these older ones should all point to the latest incarnation.
- `order`: An integer that determines the order of the overview of the 'Other browsers' page. A value of `0` means the item is not visible in the overview.
- `type`: What kind of browser or device this is. Can be a comma seperated list with the following values: `desktop`, `mobile`, `tablet`.


###Versions

Contains data about individual versions of each platform. For every release a new entry should be added. In general,
existing data should never be deleted, only new data added.


````
[
    {
        "platform": "firefox",
        "version": "38",
        "nickname": "Firefox 38",
        "release": "2015-05-12",
        "type": "desktop",
        "status": "legacy",
        "visible": 0
    }
]
````

- `platform`: The id of this platform.
- `version`: The version. Try to be as brief as possible, so not 38.0.1, but just 38.
- `nickname`: The name of this browser, os or device, including the version.
- `details`: Additional information in case of a device, like the actual browser name.
- `releasedate`: The date on which this version was released. Do not use the date of a bugfix release, only the date of major releases.
- `type`: What kind of browser or device this is. Can be a comma seperated list with the following values: `desktop`, `mobile`, `tablet`, `ereader`, `television`, `television-box`, `television-smart`, `gaming`, `gaming-portable`, `gaming-console`. A value with a dash (`-`) should always also include the portion before the dash seperately, so `gaming-console` should also include `gaming`, for example: `gaming,gaming-console`.
- `status`: Is this the `current` version, or a `legacy` version or `upcoming` version?
- `visible`: A value of `false` is not visible by default, a value of `true` is visible by default.


###Tests

This file contains the actual information that links platforms and versions to test results. This file does not have to contain an
entry for every single item in the `platforms.json` and `versions.json` file. However, if you add a new platform or version, also add the
a unique id for a test result in the `tests.json` file.

````
[
    {
        "platform": "safari",
        "version": "9.0",
        "uniqueid": "6293a82fceda7a2c"
    },
    {
        "platform": "safari",
        "version": "9.1",
        "source": "browserstack",
        "identifier": "safari-9.1|OS X-El Capitan"
    }
]
````

- `platform`: The id as specified in the `platforms.json` and `versions.json` file.
- `version`: The version as specified in the `versions.json` file.

And either:
- `uniqueid`: The unique id of a test report from the actual website. Open the website, click on 'Save results' and copy and paste the unique id.

Or:
- `source`: In case you want to use an automated BrowserStack result, the value should always be `browserstack`.
- `identifier`: The identifier of the browserstack generated result as shown by the output of the [WebPlatformTest/Automation](https://github.com/WebPlatformTest/Automation) tool.

It is preferable to use BrowserStack, because these results can be automatically re-generated whenever a new version of HTML5test is released.
Because BrowserStack mainly support desktop browsers, many of the other platforms will require manual testing and unique ids.
Test results that use a unique id will be removed when a new version is released and will have to be manually retested and re-added.
