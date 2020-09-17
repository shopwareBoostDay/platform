import Criteria from '../criteria.data';

const REPOSITORY_NAME = 'state_machine';
const TECHNICAL_NAME_ORDER_STATE = 'order.state';
const TECHNICAL_NAME_ORDER_DELIVERY_STATE = 'order_delivery.state';
const TECHNICAL_NAME_ORDER_TRANSACTION_STATE = 'order_transaction.state';

class StateMachineCacheHelper {
    constructor(repositoryFactory) {
        this.repositoryFactory = repositoryFactory;
        this.clearCache();
    }

    clearCache() {
        this.stateMachines = null;
    }

    async getOrderStates(context) {
        return (await this.getStateMachineByTechnicalName(TECHNICAL_NAME_ORDER_STATE, context)).states;
    }

    async getOrderDeliveryStates(context) {
        return (await this.getStateMachineByTechnicalName(TECHNICAL_NAME_ORDER_DELIVERY_STATE, context)).states;
    }

    async getOrderTransactionStates(context) {
        return (await this.getStateMachineByTechnicalName(TECHNICAL_NAME_ORDER_TRANSACTION_STATE, context)).states;
    }

    async getStateMachineByTechnicalName(technicalName, context) {
        if (!this.stateMachines) {
            await this.fetchStates(context);
        }

        return this.stateMachines.find((stateMachine) => stateMachine.technicalName === technicalName) || {};
    }

    async fetchStates(context) {
        this.stateMachines = await this.repositoryFactory.create(REPOSITORY_NAME).search(this.getCriteria(), context);
    }

    getCriteria() {
        const criteria = new Criteria(1, 500);
        criteria.addAssociation('states');

        return criteria;
    }
}

export default StateMachineCacheHelper;
