function withSubstitutions(str, subs = {}) {
    Object.keys(subs).forEach((key) => {
        str = str.replaceAll(`:${key}:`, subs[key]);
    });
    return str;
}

export { withSubstitutions };
