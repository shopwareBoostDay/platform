---
title: Allow creating documents without order reference
issue: NEXT-10844
author: Sven Münnich
author_email: sven.muennich@pickware.de 
author_github: svenmuennich
---
# Core
* Changes `DocumentGeneratorInterface::supports()` to expect a single `string` argument `$documentType` and return a `bool` indicating whether the passed document type is supported.
* Changes `DocumentGeneratorInterface::generate()` to remove the first argument `$order`.
* Adds new class `AbstractOrderDocumentGenerator` simplifying implementing generators for order documents.
* Fixes generation of documents in landscape orientation if they are based on `@Framework/documents/base.html.twig`.
