import BasicComponent from "../components/BasicComponents/MainComponent";
import MultipleEventComponent from "../components/ActiveComponents/EventComponents/MultipleComponent";
import SingleEventComponent from "../components/ActiveComponents/EventComponents/SingleComponent";

import RequestComponent from "../components/ActiveComponents/EventComponents/RequestComponents/MainComponent";

import MultipleUserComponent from "../components/ActiveComponents/UserComponents/MultipleComponent";
import SingleUserComponent from "../components/ActiveComponents/UserComponents/SingleComponent";

import ProfileComponent from "../components/ProfileComponents/MainComponent";
import RecommendComponent from "../components/ProfileComponents/RecommendComponent";
import CalendarComponent from "../components/ProfileComponents/CalendarComponent";

import EditComponent from "../components/ProfileComponents/EditComponents/MainComponent";

import AllowComponent from "../components/ProfileComponents/EditComponents/FieldComponents/AllowComponent";
import ContactComponent from "../components/ProfileComponents/EditComponents/FieldComponents/ContactComponent";
import MainInfoComponent from "../components/ProfileComponents/EditComponents/FieldComponents/MainInfoComponent";
import PasswordComponent from "../components/ProfileComponents/EditComponents/FieldComponents/PasswordComponent";
import PhotoComponent from "../components/ProfileComponents/EditComponents/FieldComponents/PhotoComponent";
import SpecializationComponent
    from "../components/ProfileComponents/EditComponents/FieldComponents/SpecializationComponent";
import TopicComponent from "../components/ProfileComponents/EditComponents/FieldComponents/TopicComponent";

import DashboardComponent from "../components/DashboardComponents/MainComponent";

import AdminComponent from "../components/DashboardComponents/RoleComponents/AdminComponent";
import EventModeratorComponent from "../components/DashboardComponents/RoleComponents/EventModeratorComponent";
import MainModeratorComponent from "../components/DashboardComponents/RoleComponents/MainModeratorComponent";
import OrganizerComponent from "../components/DashboardComponents/RoleComponents/OrganizerComponent";
import SpeakerComponent from "../components/DashboardComponents/RoleComponents/SpeakerComponent";
import VolunteerComponent from "../components/DashboardComponents/RoleComponents/VolunteerComponent";

import AuthComponent from "../components/AuthComponents/MainComponent";

import LoginComponent from "../components/AuthComponents/LoginComponent";
import RegisterComponent from "../components/AuthComponents/RegisterComponent";

import auth from "./middleware/auth";
import guest from "./middleware/guest";

const routes = [
    {
        path: '/',
        component: BasicComponent,
        children: [
            {
                path: '',
                name: 'events',
                component: MultipleEventComponent
            },
            {
                path: 'events/:id',
                name: 'event',
                component: SingleEventComponent
            },
            {
                path: 'users',
                name: 'users',
                component: MultipleUserComponent
            },
            {
                path: 'users/:id',
                name: 'user',
                component: SingleUserComponent
            },
            {
                path: 'request',
                name: 'request',
                component: RequestComponent,
                meta: { middleware: [ auth ] }
            },
            {
                path: 'user',
                name: 'profile',
                component: ProfileComponent,
                meta: { middleware: [ auth ] }
            },
            {
                path: 'recommendations',
                name: 'recommendations',
                component: RecommendComponent,
                meta: { middleware: [ auth ] }
            },
            {
                path: 'calendar',
                name: 'calendar',
                component: CalendarComponent,
                meta: { middleware: [ auth ] }
            },
            {
                path: 'user/edit',
                name: 'user.edit',
                component: EditComponent,
                meta: { middleware: [ auth ] },
                children: [
                    {
                        path: '',
                        name: 'edit.info',
                        component: MainInfoComponent,
                    },
                    {
                        path: 'allow',
                        name: 'edit.allow',
                        component: AllowComponent,
                    },
                    {
                        path: 'contacts',
                        name: 'edit.contacts',
                        component: ContactComponent,
                    },
                    {
                        path: 'reset',
                        name: 'edit.password',
                        component: PasswordComponent,
                    },
                    {
                        path: 'photo',
                        name: 'edit.photo',
                        component: PhotoComponent,
                    },
                    {
                        path: 'specialization',
                        name: 'edit.specialization',
                        component: SpecializationComponent,
                    },
                    {
                        path: 'topics',
                        name: 'edit.topics',
                        component: TopicComponent,
                    }
                ]
            }

        ]
    },
    {
        path: '/auth',
        component: AuthComponent,
        children: [
            {
                path: 'login',
                name: 'auth.login',
                component: LoginComponent,
                meta: { middleware: [ guest ] }
            },
            {
                path: 'register',
                name: 'auth.register',
                component: RegisterComponent,
                meta: { middleware: [ guest ] }
            }
        ]
    },
    {
        path: '/dashboard',
        component: DashboardComponent,
        meta: { middleware: [ auth ] },
        children: [
            {
                path: 'admin',
                name: 'dashboard.admin',
                component: AdminComponent
            },
            {
                path: 'event-moderator',
                name: 'dashboard.event-moderator',
                component: EventModeratorComponent
            },
            {
                path: 'main-moderator',
                name: 'dashboard.main-moderator',
                component: MainModeratorComponent
            },
            {
                path: 'organizer',
                name: 'dashboard.organizer',
                component: OrganizerComponent
            },
            {
                path: 'speaker',
                name: 'dashboard.speaker',
                component: SpeakerComponent
            },
            {
                path: 'volunteer',
                name: 'dashboard.volunteer',
                component: VolunteerComponent
            }
        ]
    }
];

export default routes;
