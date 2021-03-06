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
        tokens: "Buy Job Posts",
        resume_pass: "Resume Pass",
        purchases: "Purchases",
        dashboard: "Home",
    },
    actions: {
        edit: "Edit",
        edit_images: "Edit",
        back: "back",
        view: "View",
        images: "Images",
        publish: "Publish",
    },
    show_profile: {
        title: "School Profile",
        logo: "School Logo",
        images: "School Images",
        no_images:
            "You haven't uploaded any images of your school yet. Adding photos of your school improves your profile.",
        disabled:
            "Your school's profile has been disabled by ELT Search. If you wish to discuss this decision further, please contact us at service@eltsearch.com",
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
        no_posts: "There are no job posts from your school yet.",
    },
    show_job_post: {
        title: "Job Post",
    },
    post_images: {
        title: "Job Post Images",
        prompt: "Add up to 4 images to be shown with your job post.",
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
        use_english:
            "Please remember to use English when filling out the form, as teachers need to be able to read the information.",
        job: "Job",
        job_title: "Job Title",
        description: "Description of job",
        start_date_prompt: "When would you like the teacher to start?",
        school: "School",
        school_name: "Name of the school",
        location_prompt: "Where is the school located?",
        set_location: "Set location",
        no_location: "No location set",
        engagement: "Working times and Hours",
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
    publish_post: {
        title: "Publish Your Job Post",
        view_button: "View Post",
        disabled_note:
            "Your post has been disabled by ELT Search, and will not be publishable until the issue is resolved. Please email service@eltsearch.com for assistance.",
        private_note:
            "Your post was originally published on :published: and expires on :expires:. You may republish to make it live again.",
        republish: "Re-publish",
        no_tokens:
            "Sorry, you currently have not paid for and job posts. Purchasing job posts will allow you to publish.",
        buy_token: "Buy job posts",
        ready: "Your post is ready to publish.",
        publish: "Publish",
        shown_until: "If you publish today, it will be public until :expires:",
        single_cost:
            "<span class='type-b2'>Cost: </span>1 Job Post (You will have :remaining: posts left)",
        live_note:
            'Your post is currently public, and will be live on the site until <span class="type-b2">:expires:</span>. You may retract the post if you would like to not have it shown publicly anymore. Note that this will not affect the date when the post will be retired.',
        retract: "Retract",
        published: "Your post has been published",
        publish_error: "Unable to publish post",
        retracted: "Your post has been retracted",
        retract_error: "Unable to retract post",
        expired_note:
            "Your job post has expired. If you are sure the contents of the post are still accurate and valid, you may republish the post again, as if it were new.",
        profile_disabled:
            "You may not publish job posts while your school profile is disabled.",
    },
    incomplete_post_publish: {
        explain:
            "Your post is not complete enough to publish. Please review your post, and complete any missing sections",
        edit: "Edit Post",
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
        years_experience: "Years of Teaching Experience",
        native_language: "Native language",
        other_languages: "Other languages",
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
        sender: "Sender",
        subject: "Subject",
        back_button: "Back to Inbox",
        delete_button: "Delete message",
        unread_button: "Leave message as unread",
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
        info: "Billing Info",
        note: "Note",
        incomplete:
            "Your billing details are not complete. Please update your billing info before you make any purchases.",
        update: "Update Billing Info",
    },
    tokens: {
        get_tokens: "Purchase Job Posts",
        token_count: "You have :count: post(s)",
    },
    resume_pass: {
        title: "My Resume Pass",
        valid_until: "Valid until :date:",
        expires:
            "Your resume pass will expire in <span class='type-b2'>:days: days</span>",
        extend: "Extend your pass",
        use_filters:
            "Use filters to narrow your search by location, nationality or teaching experience",
        filters: "Filters",
        total_records:
            "Found :total_records: resumes. Showing page :page: of :total_pages:",
        next_page: "Next page",
        prev_page: "Prev page",
        no_results: "There are no results to show.",
        teacher_name: "Teacher's Name",
        nationality: "Nationality",
        age: "Age",
        only_in_area: "Only" + " in my area",
        location: "Location",
        education: "Education",
        experience_level: "Experience level",
        years_experience: "Years experience",
        filters_clear: "Clear all",
        filters_apply: "Apply",
        get_pass: "Get the resume pass",
        prompt_one:
            "Get access to teacher resumes to help find the right teacher for your school.",
        prompt_two:
            "Find quality candidates, with the right amount of experience, and in your area.",
        get_access: "Get access now",
        filters_experience: {
            any: "Any amount of experience",
            one: "One or more years experience",
            three: "Three or more years experience",
            five: "Five or more years experience",
            ten: "Ten or more years experience",
        },
        any_nationality: "Any nationality",
    },
    resume: {
        title: "Teacher Resume",
        contact_teacher: "Contact teacher",
        age: "Age",
        experience_label: "Teaching Experience",
        experience_years: ":years: years",
        native_lang: "Native languages",
        other_langs: "Other languages",
        education: "Education",
        work_experience: "Work Experience",
        no_work_experience:
            ":name: has not added any of their previous work experience.",
    },
    purchases: {
        title: "Your Purchases",
        date: "Date",
        item: "Item",
        price: "Price",
        status: "Status",
        purchased_by: "Purchased By",
    },
    dashboard: {
        greeting: "Hi :name:",
        essentials: {
            title: "Essentials",
            explain: "This is what you need to do before you get started",
            complete_action: "Complete your Profile",
            complete_reason:
                "Your profile needs to be completed before you can start posting jobs.",
            complete_done: "Your profile is complete.",
            billing_action: "Add your Billing Details",
            billing_reason:
                "You need to add your billing information before you can start posting jobs or viewing teacher resumes.",
            billing_done: "Your billing information is complete.",
        },
        suggestions: {
            title: "Suggestions",
            explain:
                "Here are some things we suggest doing to increase your Job Search prospects.",
            tokens_action: "Purchase Job Posts",
            tokens_reason:
                "You need to purchase job posts to publish. You can either purchase a single post, or a bunch at a discounted rate.",
            tokens_done: "You have posts in store.",
            resume_action: "Get the Resume Pass",
            resume_reason:
                "Get the resume pass to browse and find teachers that suit your needs.",
            resume_done: "You already have the resume pass.",
            images_action: "Upload some images",
            images_reason:
                "Adding images of your school helps teachers see what your school is like and can increase your chances of finding a new teacher.",
            images_done: "You already have added the maximum number of images.",
            post_action: "Complete your Job Post",
            post_reason:
                "You have a job post that is still a draft. There is no time like the present to get that completed.",
            post_done: "You don't have any incomplete job posts.",
        },
        connect: {
            title: "Connect with Teachers",
            explain:
                "Here are some actions you can take to possibly connect with new teachers.",
            applications_action: "Review Applications",
            applications_reason:
                "Review applications from teachers who have applied to your job post.",
            applications_done:
                "You don't have any recent applications at the moment.",
            messages_action: "Check your Messages",
            messages_reason: "You have no new messages.",
            messages_done:
                "Check up on your unread messages, there could be an opportunity waiting for you.",
        },
    },

    recruit: {
        title: "Contact Teacher",
        explanation:
            "Send a message to <span class='type-b2'>:name:</span> if you'd like them to get in touch. Once they have read your message they will be able to contact you.",
        previous_contacts:
            "You have already sent a message to :name: on these dates:",
        warning:
            "Please be aware that some teachers may not enjoy being contacted too often. You may only message a teacher three limes in a two-month period.",
        forbidden:
            "You have already contacted :name: three times in the last two months. You may not send another message at this time.",
        message_label: "Your message",
        contact_person: "Contact person name",
        contact_help: "Who should the teacher ask to speak to?",
        email: "Email address",
        phone: "Phone number",
        submit: "Send message",
        profile_disabled:
            "You may not contact teachers while your profile is disabled.",
    },
    choose_location: {
        country: "Country",
        region: "Region",
        area: "Area",
        cancel: "Cancel",
        done: "Done",
    },
    purchase_no_billing: {
        explain:
            "Your billing info is incomplete. Please update before you proceed.",
        edit: "Edit billing info",
        title: "Billing info",
    },
    purchasing: {
        purchase: "Purchase",
        buy_now: "Buy Now for :price:",
    },
};
