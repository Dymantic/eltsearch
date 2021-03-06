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
import EditSchoolBillingDetails from "../../vue/Pages/Schools/EditSchoolBillingDetails";
import PurchaseItem from "../../vue/Pages/Schools/PurchaseItem";
import PastPurchases from "../../vue/Pages/Schools/PastPurchases";
import PurchaseDetails from "../../vue/Pages/Schools/PurchaseDetails";
import PurchaseTokens from "../../vue/Pages/Schools/PurchaseTokens";
import ResumePasses from "../../vue/Pages/Schools/ResumePasses";
import CurrentResumePass from "../../vue/Pages/Schools/CurrentResumePass";
import SessionExpired from "../../vue/Pages/SessionExpired";
import TeacherResume from "../../vue/Pages/Schools/ResumePass/TeacherResume";
import RecruitTeacher from "../../vue/Pages/Schools/ResumePass/RecruitTeacher";

export default [
    { path: "/", component: SchoolDashboard },
    { path: "/session-expired", component: SessionExpired },
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
    { path: "/billing-details", component: EditSchoolBillingDetails },
    { path: "/tokens", component: PurchaseTokens },
    { path: "/purchasing/:package", component: PurchaseItem },
    { path: "/purchases", component: PastPurchases },
    { path: "/purchases/:purchase", component: PurchaseDetails },
    { path: "/resume-pass", component: CurrentResumePass },
    { path: "/resume-passes/buy", component: ResumePasses },
    { path: "/resume-pass/teachers/:teacher", component: TeacherResume },
    {
        path: "/resume-pass/teachers/:teacher/contact",
        component: RecruitTeacher,
    },
];
