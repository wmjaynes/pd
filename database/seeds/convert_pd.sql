
-- insert into users
-- (select orgid, OrgContactName, OrgEmail, OrgUserName, OrgPW, NULL, NULL, OrgLastLogin, 0, 1, 0, NULL, OrgRegDate, OrgLastLogin from tblOrgs);



insert into organizations
(id, name, address1, address2, city, state, postalCode, email, phone, contactName, url, logoUrl, description, approved)
  select
    orgid, orgname, orgaddress1, orgaddress2, orgcity, orgstate, orgzip, orgemail, orgphone, orgcontactname, orgurl, orgheaderurl,
    orgdesc, 1
  from tblOrgs;

-- insert into users
--   select * from users_save;

-- insert into organization_user (organization_id, user_id, role_id, created_at, updated_at)
-- select id, id, 2, current_timestamp(), current_timestamp() from organizations;

insert into venues
(id, name, streetAddress, addressLocality, addressRegion, postalCode, created_by, event_id, created_at, updated_at)
  select  EventID, EventVenueName, EventStreet, EventCity, EventState, EventZip, OrgID, EventID, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  from tblEvents order by tblEvents.eventid;

insert into events
(id, venue_id, organization_id, name, startDate, endDate, timeInfo,  description,
 category, contactName, phone, email, url, ticketInfo, free,
 imageUrl, flyerUrl, ticketUrl, altMapUrl,
 published, tags,  created_at, updated_at)
  select EventID, EventID, OrgID, EventName, EventStart, EventEnd, EventTimeDesc,  EventDesc,
    EventCategory, EventContactName, EventPhone, EventEmail, EventURL, EventTickets, EventFree,
    EventImageURL,EventPrURL,EventTicketURL, EventAltMapURL,
    PageVis, EventTags, EventEntryTimestamp, EventLastEdit
  from tblEvents;


-- # insert into aggregates (aggregator_id, aggregatee_id)
-- #   select OrgID, FeedOrgId from tblChannels;
insert into aggregates (id, name, organization_id) values (1, 'Events Calendar', 135);
insert into aggregates (id, name, organization_id) values (2, 'AACTMAD', 135);
insert into aggregate_organization (aggregate_id, organization_id)
    select 1, FeedOrgId from tblChannels where orgid = 135;
insert into aggregate_organization (aggregate_id, organization_id) values(2, 135);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 2762);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 824);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 830);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 2035);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 973);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 1144);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 828);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 829);
insert into aggregate_organization (aggregate_id, organization_id) values(2, 797);

update organizations set name = 'AACTMAD Tuesday English Dance' where id = 797;

-- ###############
-- Clean up the venues. Remove most of duplicates.
--
update events 
set venue_id = 7016
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%123 w%');

update events
set venue_id = 36694
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%10160%');

update events
set venue_id = 7304
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%Via Sacra Drive%');

update events
set venue_id = 35451
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%Snyder-Phillips%');

update events
set venue_id = 22801
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%7251 5%');

update events
set venue_id = 39523
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%701 5%');

update events
set venue_id = 8455
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%6800 N%');

update events
set venue_id = 26128
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%4001 Ogema%');

update events
set venue_id = 28440
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%355 E. K%');

update events
set venue_id = 22434
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%31775 Grand%');

update events
set venue_id = 13524
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%270 Dixie%');

update events
set venue_id = 40868
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1286 Otta%');

update events
set venue_id = 9956
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%134 division%');

update events
set venue_id = 3029
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%855 grove%');

update events
set venue_id = 13404
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1110 w%');

update events
set venue_id = 6115
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1130 w%');

update events
set venue_id = 7305
where venue_id in
      (SELECT venues.id FROM venues where name like '%clague%');

update events
set venue_id = 18571
where venue_id in
      (SELECT venues.id FROM venues where name like '%united meth%' and addressLocality like '%troy%');

update events
set venue_id = 7294
where venue_id in
      (SELECT venues.id FROM venues where name like '%chapel%');

update events
set venue_id = 6615
where venue_id in
      (SELECT venues.id FROM venues where name like '%oshtemo%');

update events
set venue_id = 7298
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%3337 ann%');


update events
set venue_id = 13709
where venue_id in
      (SELECT venues.id FROM venues where name like '%concourse%');

update events
set venue_id = 12819
where venue_id in
      (SELECT venues.id FROM venues where name like '%cavell%');

update events
set venue_id = 3033
where venue_id in
      (SELECT venues.id FROM venues where name like '%hannah%' and addressLocality like '%Lansing%');

update events
set venue_id = 3029
where venue_id in
      (SELECT venues.id FROM venues where name like '%unitarian%' and addressLocality like '%Lansing%');

update events
set venue_id = 58
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%215 n%');

update events
set venue_id = 9791
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%23 e%');

update events
set venue_id = 37729
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%324 west%');

update events
set venue_id = 40888
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2068 mi%');

update events
set venue_id = 40366
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1301 pi%');

update events
set venue_id = 40366
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%1580 d%');
update venues
set name = "Gretchen's House Child Care - Dhu Varren"
where id = 40366;

update events
set venue_id = 7641
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2625 tr%');
update venues
set name = "Gretchen's House Child Care - Traver"
where id = 7641;

update events
set venue_id = 40625
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2340 o%');
update venues
set name = "Gretchen's House Child Care - Oak Valley"
where id = 40625;

update events
set venue_id = 39870
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2095 pa%');

update events
set venue_id = 40494
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%4090 ge%');

update events
set venue_id = 40423
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%755 s%');

update events
set venue_id = 40931
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%200 n%');

update events
set venue_id = 40637
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2205 s%');

update events
set venue_id = 40751
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%16101 b%');

update events
set venue_id = 40853
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%125 e%');

update events
set venue_id = 40908
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%124 pe%');

update events
set venue_id = 40817
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2070 w%');

update events
set venue_id = 40928
where venue_id in
      (SELECT venues.id FROM venues where streetAddress like '%2320 c%');



delete from venues
where id not in
      (select distinct venue_id from events);

UPDATE venues SET approved = 1
WHERE id IN (7016,36694,7304,35451,22801,39523,8455,26128,28440,22434,13524,40868,
             9956,3029,13404,6115,7305,18571,7294,6615,7298,13709,12819,3033,3029,
             58,9791,37729,40888,40366,40366,7641,40625,39870,40494,40423,40931,
             40637,40751,40853,40908,40817,40928 );






  
  
