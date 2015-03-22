battlenet-api-client
====================

[![Build Status (Scrutinizer)](https://scrutinizer-ci.com/g/Jleagle/battlenet-api-client/badges/build.png)](https://scrutinizer-ci.com/g/Jleagle/battlenet-api-client)
[![Code Quality (scrutinizer)](https://scrutinizer-ci.com/g/Jleagle/battlenet-api-client/badges/quality-score.png)](https://scrutinizer-ci.com/g/Jleagle/battlenet-api-client)
[![Latest Stable Version](https://poser.pugx.org/Jleagle/battlenet-api-client/v/stable.png)](https://packagist.org/packages/Jleagle/battlenet-api-client)
[![Latest Unstable Version](https://poser.pugx.org/Jleagle/battlenet-api-client/v/unstable.png)](https://packagist.org/packages/Jleagle/battlenet-api-client)

A package to retrieve information from the Battle.net API (https://dev.battle.net/)

###### Pros
- Code hinting
- Contains all game APIs (Diablo 3, StarCraft 2 and WoW)
- Contains authed account and community APIs, with helper functions to get OAuth tokens

### Usage

Instantiate the package using your games class, passing though your API key, ServerLocation and ResponseLocale:

```php
$warcraft = new Warcraft(
  $key,
  ServerLocations::EU,
  ResponseLocales::EN_GB
);
```

Example API calls:

```php
// Retrieve auction data
$auctions = $warcraft->getAuctions('outland');

// Retrieve realm list
$realms = $warcraft->getRealms();

// Retrieve achievement details
$achievement = $warcraft->getAchievement(2144);
```
