---
title: Add functionality that products are not assignable to structure or link categories
issue: NEXT-8305
author: Sebastian Lember
author_email: lember@hochwarth-it.de
author_github: sebi007
---
# Administration
*  Added template around `sw-product-assignment-card` in `sw-category-detail-base.html.twig`
*  Added category type change modal to `sw-category-detail-base.html.twig`
*  Added new data property `showChangeTypeModal` to `sw-category-detail-base/index.js` 
*  Added new method `onChangeCategoryType` to `sw-category-detail-base/index.js`
*  Added new method `onCloseChangeTypeModal` to `sw-category-detail-base/index.js`
*  Added new method `onConfirmChangeTypeModal` to `sw-category-detail-base/index.js`
*  Added new method `canSelectCategory` to `sw-category-tree-field/index.js`
*  Added new property `displayCheckboxCallback` to `sw-tree-item/index.js`
*  Changed `displayCeckbox` to `displayCheckboxCallback()` in `sw-tree-item.html.twig`
