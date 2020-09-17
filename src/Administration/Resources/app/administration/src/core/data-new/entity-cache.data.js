import Criteria from './criteria.data';
import StateMachineCacheHelper from './entity-cache-helper/state-machine-helper';

class EntityCache {
    constructor(repositoryFactory) {
        this.repositoryFactory = repositoryFactory;
        this.clearCaches();
    }

    clearCaches() {
        this.cachedEntities = {};
        this.stateMachineCacheHelper = new StateMachineCacheHelper(this.repositoryFactory);
    }

    clearCache(entityName) {
        delete this.cachedEntities[entityName];
    }

    async find(id, entityName, context) {
        const entities = await this.findAll(entityName, context);

        return entities.find((entity) => entity.id === id);
    }

    async findAll(entityName, context) {
        if (!this.cachedEntities[entityName]) {
            this.cachedEntities[entityName] = await this.fetchFromRepository(entityName, context);
        }

        return this.cachedEntities[entityName];
    }

    fetchFromRepository(entityName, context) {
        return this.repositoryFactory
            .create(entityName)
            .search(new Criteria(1, 500), context);
    }
}

export default EntityCache;
