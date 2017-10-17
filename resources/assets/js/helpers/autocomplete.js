import algolia from 'algoliasearch';
import autocomplete from 'autocomplete.js';

var index = algolia('FLAMY3R40Y', 'bbe8d0030007acaca91243efd29ceda4');

export const userautocomplete = selector => {
	index = index.initIndex('users')

	return autocomplete(selector, {}, {
		source: autocomplete.sources.hits(index, { hitsPerPage: 15 }),
        displayKey: 'name',
        templates: {
            suggestion: function(suggestion) {
                return '<span>' + suggestion.name + '</span>';
            },
            empty: '<div class="aa-empty">No people found.</div>'
        }
	})
}