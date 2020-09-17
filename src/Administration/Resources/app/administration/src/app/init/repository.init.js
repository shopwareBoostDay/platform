const RepositoryFactory = Shopware.Classes._private.RepositoryFactory;
const { EntityHydrator, ChangesetGenerator, EntityCache, EntityFactory } = Shopware.Data;
const ErrorResolverError = Shopware.DataDeprecated.ErrorResolver;

export default function initializeRepositoryFactory(container) {
    const httpClient = container.httpClient;
    const factoryContainer = this.getContainer('factory');
    const serviceContainer = this.getContainer('service');

    return httpClient.get('_info/entity-schema.json', {
        headers: {
            Authorization: `Bearer ${serviceContainer.loginService.getToken()}`
        }
    }).then(({ data }) => {
        const entityDefinitionFactory = factoryContainer.entityDefinition;
        Object.keys(data).forEach((entityName) => {
            entityDefinitionFactory.add(entityName, data[entityName]);
        });

        const hydrator = new EntityHydrator();
        const changesetGenerator = new ChangesetGenerator();
        const entityFactory = new EntityFactory();
        const errorResolver = new ErrorResolverError();
        const createRepositoryFactory = () => new RepositoryFactory(
            hydrator,
            changesetGenerator,
            entityFactory,
            httpClient,
            errorResolver
        );
        const entityCache = new EntityCache(createRepositoryFactory());

        this.addServiceProvider('repositoryFactory', () => {
            return createRepositoryFactory();
        });
        this.addServiceProvider('entityHydrator', () => {
            return hydrator;
        });
        this.addServiceProvider('entityCache', () => {
            return entityCache;
        });
        this.addServiceProvider('entityFactory', () => {
            return entityFactory;
        });
    });
}
