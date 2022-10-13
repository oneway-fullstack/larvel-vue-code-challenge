const fullAddress = function(r) {
    return `${r.address} ${r.city} ${r.country} ${r.postal_code}`;
};

const ownerFullName = function(owner) {
    return `${owner.first_name} ${owner.last_name}`;
};

export {
    fullAddress,
    ownerFullName
}
