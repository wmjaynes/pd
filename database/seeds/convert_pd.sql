
# insert into users
# (select orgid, OrgContactName, OrgEmail, OrgUserName, OrgPW, NULL, NULL, OrgLastLogin, 0, 1, 0, NULL, OrgRegDate, OrgLastLogin from tblOrgs);



insert into organizations
(id, name, address1, address2, city, state, postalCode, email, phone, contactName, url, logoUrl, description)
  select
    orgid, orgname, orgaddress1, orgaddress2, orgcity, orgstate, orgzip, orgemail, orgphone, orgcontactname, orgurl, orgheaderurl,
    orgdesc
  from tblOrgs;

insert into users
  select * from users_save;

# insert into organization_user (organization_id, user_id, role_id, created_at, updated_at)
# select id, id, 2, current_timestamp(), current_timestamp() from organizations;

insert into venues
(name, streetAddress, addressLocality, addressRegion, postalCode, created_by, event_id, created_at, updated_at)
  select  EventVenueName, EventStreet, EventCity, EventState, EventZip, OrgID, EventID, current_timestamp(), current_timestamp()
  from tblEvents;

insert into events
(id, organization_id, name, startDate, endDate, timeInfo,  description,
 category, contactName, phone, email, url, ticketInfo, free,
 imageUrl, flyerUrl, ticketUrl, altMapUrl,
 published, tags,  created_at, updated_at)
  select EventID, OrgID, EventName, EventStart, EventEnd, EventTimeDesc,  EventDesc,
    EventCategory, EventContactName, EventPhone, EventEmail, EventURL, EventTickets, EventFree,
    EventImageURL,EventPrURL,EventTicketURL, EventAltMapURL,
    PageVis, EventTags, EventEntryTimestamp, EventLastEdit
  from tblEvents;

UPDATE events ev,
  (   SELECT id, event_id
      FROM venues
  ) ve
SET ev.venue_id = ve.id
WHERE ve.event_id = ev.id;

insert into aggregates (aggregator_id, aggregatee_id)
  select OrgID, FeedOrgId from tblChannels;

# ###############
# Clean up the venues. Remove most of duplicates.
#
update events e
set e.venue_id = 139
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%123 w%');

update events e
set e.venue_id = 1596
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%10160%');

update events e
set e.venue_id = 150
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%Via Sacra Drive%');

update events e
set e.venue_id = 2403
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%Snyder-Phillips%');

update events e
set e.venue_id = 1452
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%7251 5%');

update events e
set e.venue_id = 2259
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%701 5%');

update events e
set e.venue_id = 1567
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%6800 N%');

update events e
set e.venue_id = 1807
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%4001 Ogema%');

update events e
set e.venue_id = 1296
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%355 E. K%');

update events e
set e.venue_id = 1153
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%31775 Grand%');

update events e
set e.venue_id = 577
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%270 Dixie%');

update events e
set e.venue_id = 1726
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2625 traver%');

update events e
set e.venue_id = 1305
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1286 Otta%');

update events e
set e.venue_id = 410
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%134 division%');

update events e
set e.venue_id = 12
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%855 grove%');

update events e
set e.venue_id = 421
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1110 w%');

update events e
set e.venue_id = 267
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1130 w%');

update events e
set e.venue_id = 151
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%clague%');

update events e
set e.venue_id = 47
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%united meth%' and addressLocality like '%troy%');

update events e
set e.venue_id = 144
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%chapel%');

update events e
set e.venue_id = 116
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%oshtemo%');

update events e
set e.venue_id = 44
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%3337 ann%');


update events e
set e.venue_id = 43
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%concourse%');

update events e
set e.venue_id = 505
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%cavell%');

update events e
set e.venue_id = 16
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%hannah%' and addressLocality like '%Lansing%');

update events e
set e.venue_id = 12
where e.venue_id in
      (SELECT venues.id FROM venues where name like '%unitarian%' and addressLocality like '%Lansing%');

update events e
set e.venue_id = 1
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%215 n%');

update events e
set e.venue_id = 386
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%23 e%');

update events e
set e.venue_id = 2879
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%324 west%');

update events e
set e.venue_id = 3092
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2068 mi%');

update events e
set e.venue_id = 1389
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1301 pi%');
update venues v
  set v.name = 'Brennan Community Center'
where v.id = 1389;

update events e
set e.venue_id = 1149
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1580 d%');
update venues v
set v.name = "Gretchen's House Child Care - Dhu Varren"
where v.id = 1149;

update events e
set e.venue_id = 1726
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1625 tr%');
update venues v
set v.name = "Gretchen's House Child Care - Traver"
where v.id = 1726;

update events e
set e.venue_id = 2240
where e.venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2095 pa%');

delete from venues
where id not in
      (select distinct venue_id from events);

UPDATE venues SET approved = 1
WHERE id IN (1726, 1149, 2240,1389, 3092, 2879, 386, 1, 12, 16, 505, 43, 44, 116, 144, 47, 151, 267, 421,
            12, 410, 1305, 1726, 577, 1153, 1296, 1807, 1567, 2259, 1452, 2403, 150, 1569, 139 );





  
  
  