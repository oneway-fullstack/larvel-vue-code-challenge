import Owners from './components/Owner/Owners.vue';
import OwnerView from "./components/Owner/OwnerView";
import OwnerEdit from "./components/Owner/OwnerEdit";
import Addresses from './components/Address/Addresses.vue';
import AddressView from "./components/Address/AddressView";
import AddressEdit from "./components/Address/AddressEdit";
import Cars from './components/Car/Cars.vue';
import CarView from "./components/Car/CarView";
import CarEdit from "./components/Car/CarEdit";

export const routes = [
    {
        name: 'owners',
        path: '/owners',
        component: Owners
    },
    {
        name: 'owners.view',
        path: '/owners/:id',
        component: OwnerView
    },
    {
        name: 'owners.edit',
        path: '/owners/:id/edit',
        component: OwnerEdit
    },
    {
        name: 'addresses',
        path: '/addresses',
        component: Addresses
    },
    {
        name: 'addresses.view',
        path: '/addresses/:id',
        component: AddressView
    },
    {
        name: 'addresses.edit',
        path: '/addresses/:id/edit',
        component: AddressEdit
    },
    {
        name: 'cars',
        path: '/cars',
        component: Cars
    },
    {
        name: 'cars.view',
        path: '/cars/:id',
        component: CarView
    },
    {
        name: 'cars.edit',
        path: '/cars/:id/edit',
        component: CarEdit
    }
];
