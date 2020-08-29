import LocationsPage from "../../vue/Components/Admin/LocationsPage";
import AdminDashboard from "../../vue/Components/Admin/AdminDashboard";
import CountryPage from "../../vue/Components/Admin/CountryPage";
import ChangePassword from "../../vue/Components/ChangePassword";
import SchoolTypesPage from "../../vue/Pages/Admin/SchoolTypesPage";
import CreateSchoolType from "../../vue/Pages/Admin/CreateSchoolType";
import EditSchoolType from "../../vue/Pages/Admin/EditSchoolType";

export default [
    { path: "/", component: AdminDashboard },
    { path: "/change-password", component: ChangePassword },
    { path: "/locations", component: LocationsPage },
    { path: "/countries/:country", component: CountryPage },
    { path: "/school-types", component: SchoolTypesPage },
    { path: "/school-types/create", component: CreateSchoolType },
    { path: "/school-types/:type/edit", component: EditSchoolType },
];
