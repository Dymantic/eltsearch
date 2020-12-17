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
import TeacherApplications from "../../vue/Pages/Teachers/TeacherApplications";
import ApplicationPost from "../../vue/Pages/ApplicationPost";
import ApplicationDetails from "../../vue/Pages/Teachers/ApplicationDetails";
import ShowOfInterest from "../../vue/Pages/Teachers/ShowOfInterest";
import Notifications from "../../vue/Pages/Notifications";
import ShowNotification from "../../vue/Pages/ShowNotification";
import JobMatchesIndex from "../../vue/Pages/Teachers/JobMatchesIndex";
import MatchedJobPost from "../../vue/Pages/Teachers/MatchedJobPost";
import CreateApplication from "../../vue/Pages/Teachers/CreateApplication";
import SessionExpired from "../../vue/Pages/SessionExpired";
import ApplyToPost from "../../vue/Pages/Teachers/ApplyToPost";
import RecruitmentMessage from "../../vue/Pages/Teachers/Recruitment/RecruitmentMessage";

export default [
    { path: "/", component: TeacherDashboard },
    { path: "/session-expired", component: SessionExpired },
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
    { path: "/applications", component: TeacherApplications },
    { path: "/apply-to-post/:post", component: ApplyToPost },
    { path: "/applications/:application/post", component: ApplicationPost },
    {
        path: "/applications/:application/details",
        component: ApplicationDetails,
    },
    {
        path: "/applications/:application/show-of-interest",
        component: ShowOfInterest,
    },
    {
        path: "/notifications",
        component: Notifications,
    },
    {
        path: "/notifications/:notification",
        component: ShowNotification,
    },
    { path: "/job-matches", component: JobMatchesIndex },
    { path: "/job-matches/:job_match/post", component: MatchedJobPost },
    { path: "/job-matches/:job_match/apply", component: CreateApplication },
    {
        path: "/recruitments/:recruitment/details",
        component: RecruitmentMessage,
    },
];
