---
title: NEXT-10854
issue: NEXT-10854
author: Yann Karl
author_email: y.karl@webweit.de 
author_github: yannick80
---
# Core
*  Renamed `cacheDir` to `projectDir`, updated write path for `dump` in `src/Core/Framework/Plugin/BundleConfigDumper.php`
*  Switched from `%kernel.cache_dir%` to `%kernel.project_dir%` in service description for `BundleConfigDumper` in `src/Core/Framework/DependencyInjection/plugin.xml`

___
# Storefront
*  Renamed `cacheDir` to `projectDir`, updated write path for `execute`  in `src/Storefront/Theme/Command/ThemeDumpCommand.php`
*  Switched from `%kernel.cache_dir%` to `%kernel.project_dir%` in service description for `ThemeDumpCommand` in `src/Storefront/DependencyInjection/theme.xml`
*  Switched from `kernel.cache_dir` to `kernel.project_dir` for `testExecuteShouldResolveThemeInheritanceChainAndConsiderThemeIdArgument` in `src/Storefront/Test/Theme/Command/ThemeDumpCommandTest.php`
