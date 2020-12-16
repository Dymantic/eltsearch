<template>
    <div class="flex flex-col md:flex-row justify-between max-w-2xl">
        <div>
            <p class="type-h3 text-navy">{{ teacher.name }}</p>
            <p class="type-h4">{{ teacher.nationality }}</p>
            <p>
                <span class="type-b2">Age: </span>{{ teacher.age }} ({{
                    teacher.date_of_birth
                }})
            </p>
            <p>
                <span class="type-b2">Teaching Experience: </span
                >{{ teacher.years_experience }}
                {{ teacher.years_experience === 1 ? "year" : "years" }}
            </p>
            <p>
                <span class="type-b2">Native Language: </span
                >{{ teacher.native_language }}
            </p>
            <p>
                <span class="type-b2">Other languages: </span
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
