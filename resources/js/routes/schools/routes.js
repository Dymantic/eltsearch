import SchoolDashboard from "../../vue/Pages/Schools/SchoolDashboard";
import ChangePassword from "../../vue/Components/ChangePassword";
import SchoolProfilePage from "../../vue/Pages/Schools/SchoolProfilePage";
import EditSchoolProfile from "../../vue/Pages/Schools/EditSchoolProfile";
import CreateJobPost from "../../vue/Pages/Schools/CreateJobPost";
import JobPostsPage from "../../vue/Pages/Schools/JobPostsPage";
import EditJobPost from "../../vue/Pages/Schools/EditJobPost";
import ShowJobPost from "../../vue/Pages/Schools/ShowJobPost";
import PublishJobPost from "../../vue/Pages/Schools/PublishJobPost";
import SchoolProfileImages from "../../vue/Pages/Schools/SchoolProfileImages";
import JobPostImages from "../../vue/Pages/Schools/JobPostImages";
import SchoolApplications from "../../vue/Pages/Schools/SchoolApplications";
import ShowApplication from "../../vue/Pages/Schools/ShowApplication";
import ContactApplicant from "../../vue/Pages/Schools/ContactApplicant";
import Notifications from "../../vue/Pages/Notifications";
import ShowNotification from "../../vue/Pages/ShowNotification";

export default [
    { path: "/", component: SchoolDashboard },
    { path: "/change-password", component: ChangePassword },
    { path: "/profile", component: SchoolProfilePage },
    { path: "/profile/edit", component: EditSchoolProfile },
    { path: "/profile/images", component: SchoolProfileImages },
    { path: "/job-posts", component: JobPostsPage },
    { path: "/job-posts/create", component: CreateJobPost },
    { path: "/job-posts/:post/show", component: ShowJobPost },
    { path: "/job-posts/:post/edit", component: EditJobPost },
    { path: "/job-posts/:post/publish", component: PublishJobPost },
    { path: "/job-posts/:post/images", component: JobPostImages },
    { path: "/applications", component: SchoolApplications },
    { path: "/applications/:application", component: ShowApplication },
    { path: "/applications/:application/contact", component: ContactApplicant },
    { path: "/notifications", component: Notifications },
    { path: "/notifications/:notification", component: ShowNotification },
];
