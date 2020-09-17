---
title: Allow URL query parameters in POST /api/v{number}/search/{entity} requests
issue: NEXT-7952
author: Carsten Dietrich
author_email: 3203968+carstendietrich@users.noreply.github.com
author_github: @carstendietrich
---
# Core
* Changed `\Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder::handleRequest`
  to allow URL query parameters even if the HTTP method is not `GET`.
  This allows to specify search criteria e.g. for the limit via query parameters directly in the URL (`search/product?limit=10`).
  If a criterion is specified both in the request body and in the URL query parameters, the criterion specified in the request body is used.
