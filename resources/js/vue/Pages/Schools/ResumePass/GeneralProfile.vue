<template>
    <div class="flex flex-col md:flex-row justify-between max-w-2xl">
        <div>
            <p class="type-h3 text-navy">{{ teacher.name }}</p>
            <p class="type-h4 mb-2">{{ teacher.nationality }}</p>
            <p class="mb-1">
                <span class="type-b2">{{ trns("resume.age") }}: </span
                >{{ teacher.age }} ({{ teacher.date_of_birth }})
            </p>
            <p class="mb-1">
                <span class="type-b2"
                    >{{ trns("resume.experience_label") }}: </span
                >{{
                    trns("resume.experience_years", "", {
                        years: teacher.years_experience,
                    })
                }}
            </p>
            <p class="mb-1">
                <span class="type-b2">{{ trns("resume.native_lang") }}: </span
                >{{ teacher.native_language }}
            </p>
            <p class="mb-1">
                <span class="type-b2">{{ trns("resume.other_langs") }}: </span
                >{{ teacher.other_languages || "None supplied" }}
            </p>
        </div>
        <div>
            <img
                :src="teacher.avatar"
                class="w-40 h-40 object-cover rounded-full block mx-auto mt-6 md:mt-0"
            />
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["teacher"],
};
</script>
