---
title: Fix product SEO url handling for translations in administration
issue: NEXT-9809
author: Timo Helmke
author_email: t.helmke@kellerkinder.de 
author_github: @t2oh4e
___
# Administration
* Added properties `foreignKey`, `pathInfo`, `routeName` to `sw-seo-url` component
* Added properties `foreignKey`, `pathInfo`, `routeName` to `sw-seo-url` field in `sw-product-detail-base.html.twig`
* Changed `sw-product-detail` to differentiate between new and existing seo urls
