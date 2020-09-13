import ChangePassword from "../../vue/Components/ChangePassword";
import TeacherDashboard from "../../vue/Pages/Teachers/TeacherDashboard";
import EditProfileInfo from "../../vue/Components/Teachers/EditProfileInfo";
import EditEducation from "../../vue/Components/Teachers/EditEducation";
import PreviousEmploymentsIndex from "../../vue/Components/Teachers/PreviousEmploymentsIndex";
import AddPreviousEmployment from "../../vue/Components/Teachers/AddPreviousEmployment";
import EditPreviousEmployment from "../../vue/Components/Teachers/EditPreviousEmployment";
import ProfilePage from "../../vue/Pages/Teachers/ProfilePage";
import EditJobSearch from "../../vue/Components/Teachers/EditJobSearch";
import ShowJobSearch from "../../vue/Components/Teachers/ShowJobSearch";

export default [
    { path: "/", component: TeacherDashboard },
    { path: "/profile", component: ProfilePage },
    { path: "/change-password", component: ChangePassword },
    { path: "/general-info/edit", component: EditProfileInfo },
    { path: "/education/edit", component: EditEducation },
    { path: "/previous-employments", component: PreviousEmploymentsIndex },
    { path: "/previous-employments/create", component: AddPreviousEmployment },
    {
        path: "/previous-employments/:employment/edit",
        component: EditPreviousEmployment,
    },
    { path: "/job-search/show", component: ShowJobSearch },
    { path: "/job-search/edit", component: EditJobSearch },
];
