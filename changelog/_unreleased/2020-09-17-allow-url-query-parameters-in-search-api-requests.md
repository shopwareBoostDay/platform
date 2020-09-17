---
title: Allow URL query parameters in POST /api/v{number}/search/{entity} requests
issue: NEXT-7952
author: Carsten Dietrich
author_email: 3203968+carstendietrich@users.noreply.github.com
author_github: @carstendietrich
---
# Core
* Update `\Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder::handleRequest`
  to allow URL query parameters even if the HTTP method is not `GET`.
  This allows for specifying params e.g. for limit via query params in the URL (`search/product?limit=10`).
  If a key is specified both in the request body and in the URL query parameters then the one in the body will be used.
  
___
# API
*  
___
