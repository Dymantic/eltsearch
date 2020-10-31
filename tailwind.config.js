module.exports = {
    purge: [],
    theme: {
        extend: {
            colors: {
                "sky-blue": "#2B74D9",
                navy: "#1F2C72",
                "baby-blue": "#e0f0ff",
                "dark-gray": "#6B7078",
                "medium-gray": "#E1E2E3",
                "light-gray": "#F5F5F5",
                black: "#131A21",
            },
            fontFamily: {
                sans: [
                    "Raleway",
                    "-apple-system",
                    "BlinkMacSystemFont",
                    '"Segoe UI"',
                    "Roboto",
                    '"Helvetica Neue"',
                    "Arial",
                    "sans-serif",
                    '"Apple Color Emoji"',
                    '"Segoe UI Emoji"',
                    '"Segoe UI Symbol"',
                    '"Noto Color Emoji"',
                ],
            },
            fontSize: {
                "6xl": "4.5rem",
            },
            spacing: {
                80: "20rem",
            },
            inset: {
                16: "4rem",
                20: "5rem",
                50: "50%",
            },
        },
    },
    variants: {
        borderWidth: ["responsive", "last", "hover", "focus"],
    },
    plugins: [],
};
