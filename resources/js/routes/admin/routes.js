import LocationsPage from "../../vue/Components/Admin/LocationsPage";
import AdminDashboard from "../../vue/Components/Admin/AdminDashboard";
import CountryPage from "../../vue/Components/Admin/CountryPage";
import ChangePassword from "../../vue/Components/ChangePassword";
import SchoolTypesPage from "../../vue/Pages/Admin/SchoolTypesPage";
import CreateSchoolType from "../../vue/Pages/Admin/CreateSchoolType";
import EditSchoolType from "../../vue/Pages/Admin/EditSchoolType";
import AnnouncementsIndex from "../../vue/Pages/Admin/AnnouncementsIndex";
import CreatePublicAnnouncement from "../../vue/Pages/Admin/CreatePublicAnnouncement";
import CreateTeachersAnnouncement from "../../vue/Pages/Admin/CreateTeachersAnnouncement";
import CreateSchoolsAnnouncement from "../../vue/Pages/Admin/CreateSchoolsAnnouncement";
import AnnouncementShow from "../../vue/Pages/Admin/AnnouncementShow";
import AnnouncementEdit from "../../vue/Pages/Admin/AnnouncementEdit";
import JobPostsOverview from "../../vue/Pages/Admin/Posts/JobPostsOverview";
import PostShow from "../../vue/Pages/Admin/Posts/PostShow";
import TeacherOverview from "../../vue/Pages/Admin/Teachers/TeacherOverview";
import TeacherShow from "../../vue/Pages/Admin/Teachers/TeacherShow";
import TeachersBrowse from "../../vue/Pages/Admin/Teachers/TeachersBrowse";
import PostsBrowse from "../../vue/Pages/Admin/Posts/PostsBrowse";
import SchoolsOverview from "../../vue/Pages/Admin/Schools/SchoolsOverview";
import SchoolShow from "../../vue/Pages/Admin/Schools/SchoolShow";
import SchoolBrowse from "../../vue/Pages/Admin/Schools/SchoolBrowse";
import PurchasesBrowse from "../../vue/Pages/Admin/Purchases/PurchasesBrowse";
import PurchasesIndex from "../../vue/Pages/Admin/Purchases/PurchasesIndex";
import PurchaseShow from "../../vue/Pages/Admin/Purchases/PurchaseShow";
import SessionExpired from "../../vue/Pages/SessionExpired";
import Notifications from "../../vue/Pages/Notifications";
import ShowNotification from "../../vue/Pages/ShowNotification";

export default [
    { path: "/", redirect: "/job-posts" },
    { path: "/session-expired", component: SessionExpired },
    { path: "/change-password", component: ChangePassword },
    { path: "/locations", component: LocationsPage },
    { path: "/countries/:country", component: CountryPage },
    { path: "/school-types", component: SchoolTypesPage },
    { path: "/school-types/create", component: CreateSchoolType },
    { path: "/school-types/:type/edit", component: EditSchoolType },
    { path: "/announcements", component: AnnouncementsIndex },
    {
        path: "/announcements/create-public",
        component: CreatePublicAnnouncement,
    },
    {
        path: "/announcements/create-schools",
        component: CreateSchoolsAnnouncement,
    },
    {
        path: "/announcements/create-teachers",
        component: CreateTeachersAnnouncement,
    },
    {
        path: "/announcements/:announcement/show",
        component: AnnouncementShow,
    },
    {
        path: "/announcements/:announcement/edit",
        component: AnnouncementEdit,
    },
    {
        path: "/job-posts",
        component: JobPostsOverview,
    },
    {
        path: "/job-posts/browse",
        component: PostsBrowse,
    },
    {
        path: "/job-posts/:post/show",
        component: PostShow,
    },
    {
        path: "/teachers",
        component: TeacherOverview,
    },
    {
        path: "/teachers/:teacher/show",
        component: TeacherShow,
    },
    {
        path: "/teachers/browse",
        component: TeachersBrowse,
    },
    {
        path: "/schools",
        component: SchoolsOverview,
    },
    {
        path: "/schools/browse",
        component: SchoolBrowse,
    },
    {
        path: "/schools/:school/show",
        component: SchoolShow,
    },
    {
        path: "/purchases",
        component: PurchasesIndex,
    },
    {
        path: "/purchases/:purchase/show",
        component: PurchaseShow,
    },
    {
        path: "/purchases/browse",
        component: PurchasesBrowse,
    },
    {
        path: "/notifications",
        component: Notifications,
    },
    {
        path: "/notifications/:notification",
        component: ShowNotification,
    },
];
