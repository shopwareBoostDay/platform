---
title:              Add entity cache service
issue:              NEXT-10853
author:             Hannes Wernery
author_email:       hannes.wernery@pickware.de
author_github:      @hanneswernery
---
# Administration
* Adds an entity cache service (`entityCache`) to fetch entities that will probably not change during runtime more efficiently. It also provides entity-specific convenience functions (i.e. for entity `state_machine`).
