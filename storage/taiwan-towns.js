const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');

getPage().then(({data}) => {
    const ch = cheerio.load(data);

    const towns = [];
    
    ch('table.wikitable tbody tr').each((i, el) => {
        const district = ch('td:nth-child(2)', el).text().trim();
        const en_name = ch('td:nth-child(3)', el).text().trim();
        const zh_name = ch('td:nth-child(4)', el).text().trim();
        towns.push({district, en_name, zh_name});
        // console.log(ch('td:nth-child(3)', el).text(), ch('td:nth-child(4)', el).text());
        // console.log(el.text());
        // console.log(cheerio('td:nth-child(3)', el.html()).text());
        // console.log(index.text)
    });

    const json = towns.reduce((taiwan, town) => {
        if(Object.keys(taiwan).includes(town.district)) {
            taiwan[town.district].push({en: town.en_name, zh: town.zh_name});
            return taiwan;
        }
        taiwan[town.district] = [{en:town.en_name, zh: town.zh_name}];
        return taiwan;
    }, {});

    fs.writeFile('taiwan-towns.json', JSON.stringify(json), () => console.log('done'), () => console.log('oops'));
     console.log(JSON.stringify(json));
});

function getPage() {
    return axios.get('https://en.wikipedia.org/wiki/List_of_townships/cities_and_districts_in_Taiwan');
}

function getTable(html) {
    const table = cheerio('table.sortable', html);

    return table;
}