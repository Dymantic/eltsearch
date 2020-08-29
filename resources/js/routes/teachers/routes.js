import ChangePassword from "../../vue/Components/ChangePassword";
import TeacherDashboard from "../../vue/Pages/Teachers/TeacherDashboard";
import EditProfileInfo from "../../vue/Components/Teachers/EditProfileInfo";
import EditEducation from "../../vue/Components/Teachers/EditEducation";
import PreviousEmploymentsIndex from "../../vue/Components/Teachers/PreviousEmploymentsIndex";
import AddPreviousEmployment from "../../vue/Components/Teachers/AddPreviousEmployment";
import EditPreviousEmployment from "../../vue/Components/Teachers/EditPreviousEmployment";
import JobSearch from "../../vue/Components/Teachers/JobSearch";

export default [
    { path: "/", component: TeacherDashboard },
    { path: "/change-password", component: ChangePassword },
    { path: "/general-info/edit", component: EditProfileInfo },
    { path: "/education/edit", component: EditEducation },
    { path: "/previous-employments", component: PreviousEmploymentsIndex },
    { path: "/previous-employments/create", component: AddPreviousEmployment },
    {
        path: "/previous-employments/:employment/edit",
        component: EditPreviousEmployment,
    },
    { path: "/job-search/edit", component: JobSearch },
];
