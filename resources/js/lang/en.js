import errors from "./errors_en";
export default {
    errors,
    nav: {
        profile: "Profile",
        posts: "Job Posts",
        applications: "Applications",
        change_password: "Change Password",
        logout: "Logout",
        notifications: "Messages",
        billing: "Billing",
        tokens: "Buy Tokens",
        purchases: "Purchases",
    },
    actions: {
        edit: "Edit",
        edit_images: "Edit images",
        back: "back",
        view: "View",
        images: "Images",
        publish: "Publish",
    },
    show_profile: {
        title: "School Profile",
        images: "School Images",
    },
    edit_profile: {
        title: "Edit School Profile",
        labels: {
            name: "School name",
            intro: "Introduction",
            location: "Main School Location",
            set_location: "Set location",
            type: "Type of School",
            type_help:
                "Choose what types your school falls into. You may select more than one.",
            submit: "Update School Profile",
        },
        success: "School profile updated.",
        no_location: "No location set",
    },
    posts_index: {
        title: "Job Posts",
        create_post: "Create New Post",
        card: {
            status: "status",
        },
    },
    show_job_post: {
        title: "Job Post",
    },
    post_images: {
        title: "Job Post Images",
        gallery_title: "School Images",
        actions: {
            view: "View Post",
            back: "Posts",
        },
    },

    job_post: {
        start_date: "Starting Date",
        salary: "Salary",
        contract: "Contract",
        hours: "Hours",
        times: "Times",
        weekends: "Weekends",
        description: "Job Description",
        students: "Student Ages",
        benefits: "Job Benefits",
        requirements: "Requirements",
    },

    job_post_form: {
        job: "Job",
        job_title: "Job Title",
        description: "Description of job",
        start_date_prompt: "When would you like the teacher to start?",
        school: "School",
        school_name: "Name of the school",
        location_prompt: "Where is the school located?",
        set_location: "Set location",
        no_location: "No location set",
        engagement: "Engagement",
        engagement_prompt: "Is the job part time or full time?",
        part_time: "Part time",
        full_time: "Full time",
        hours_prompt:
            "How many hours approximately would the teacher work per week?",
        hours: "Hours per week",
        weekends_prompt:
            "Is the teacher required to work on Saturdays or Sundays?",
        yes: "Yes",
        no: "No",
        times_prompt: "What time of days would the teacher be working?",
        students: "Students",
        student_age_prompt: "What age of students would the teacher teach?",
        student_number_prompt: "How many students are in each class?",
        min: "Min",
        max: "Max",
        requirements: "Requirements",
        requirements_prompt: "What do you require from the teacher?",
        salary: "Salary",
        salary_rate_prompt: "What rate is the salary based on?",
        salary_total_prompt: "What salary are you offering",
        benefits: "Benefits",
        benefits_prompt: "Which of these benefits do you offer?",
        contract: "Contract",
        contract_prompt: "What contract length do you offer?",
        submit: "Save Job Post",
        submit_and_publish: "Save & Publish",
        success: "Your post has been saved",
    },
    show_interest_form: {
        name: "Contact person name",
        name_prompt: "Who should the teacher get in touch with?",
        email: "Email address",
        email_prompt: "What email address can the teacher use to get in touch?",
        phone: "Phone number",
        phone_prompt: "What phone number can the teacher call to get in touch?",
        submit: "Contact Teacher",
        success: "The teacher has been contacted.",
    },
    contact_applicant: {
        title: "Contact Applicant",
        instruction:
            "You may contact the applicant by reaching out directly using the contact details provided, or my letting them know you are interested and providing contact details for them to contact you with.",
        direct: "Contact Directly",
        email: "Email",
        phone: "Phone",
        not_provided: "Not provided",
        inform: "Inform Applicant",
        already_shown_interest:
            "You have already contacted the teacher. If you wish to reach out again, contact the teacher directly.",
    },
    create_post: {
        title: "Create Job Post",
    },
    edit_post: {
        title: "Edit Job Post",
    },
    applications: {
        title: "Applications",
        view_resume: "View Resume",
    },
    show_application: {
        title: "Applicant",
        contact: "Contact Teacher",
        position: "Position",
        school: "School",
        profile: "Profile",
        name: "Name",
        nationality: "Nationality",
        age: "Age",
        date_of_birth: "Date of Birth",
        cover_letter: "Introduction",
        education: "Education",
        work_experience: "Work Experience",
    },
    notifications: {
        index_title: "Messages",
        show_title: "Message",
        received: "Received",
        subject: "Subject",
        back_button: "Back to Inbox",
        delete_button: "Delete message",
        deleted: "Notification deleted.",
        empty_inbox: "There are no messages for you at the moment.",
    },
    billing: {
        address_label: "Address",
        city_label: "City",
        country_label: "Country",
        zip_label: "Postal Code",
        state_label: "State",
        submit: "Update Billing Info",
        success: "Billing details updated",
    },
};
