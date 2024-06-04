--
-- PostgreSQL database dump
--

-- Dumped from database version 14.10 (Debian 14.10-1.pgdg120+1)
-- Dumped by pg_dump version 14.10

-- Started on 2024-06-03 13:10:12

SET statement_timeout = 0;

SET lock_timeout = 0;

SET idle_in_transaction_session_timeout = 0;

SET client_encoding = 'UTF8';

SET standard_conforming_strings = on;

SELECT pg_catalog.set_config ('search_path', '', false);

SET check_function_bodies = false;

SET xmloption = content;

SET client_min_messages = warning;

SET row_security = off;

--
-- TOC entry 3516 (class 1262 OID 16384)
-- Name: MethodSovet; Type: DATABASE; Schema: -; Owner: postgres
--

-- CREATE DATABASE "MethodSovet" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'en_US.utf8';

ALTER DATABASE "MethodSovet" OWNER TO postgres;

\connect "MethodSovet" 

SET statement_timeout = 0;

SET lock_timeout = 0;

SET idle_in_transaction_session_timeout = 0;

SET client_encoding = 'UTF8';

SET standard_conforming_strings = on;

SELECT pg_catalog.set_config ('search_path', '', false);

SET check_function_bodies = false;

SET xmloption = content;

SET client_min_messages = warning;

SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- CREATE SCHEMA public;

ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 3517 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';

--
-- TOC entry 236 (class 1259 OID 16585)
-- Name: all_works; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.all_works AS
SELECT
    NULL::bigint AS id_work,
    NULL::character varying(255) AS name_work,
    NULL::text AS name_subject_area,
    NULL::real AS original_percent,
    NULL::timestamp(0) without time zone AS created_at,
    NULL::real AS final_grade,
    NULL::character varying(255) AS status,
    NULL::bigint AS id_protocol,
    NULL::text AS file_name,
    NULL::text AS experts,
    NULL::text AS file_text_percent1,
    NULL::text AS file_text_percent2,
    NULL::text AS file_text_percent3,
    NULL::text AS file_text_percent4,
    NULL::text AS file_text_percent5,
    NULL::real AS percent1,
    NULL::real AS percent2,
    NULL::real AS percent3,
    NULL::real AS percent4,
    NULL::real AS percent5;

ALTER TABLE public.all_works OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 209 (class 1259 OID 16389)
-- Name: autors_works; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.autors_works (
    id_user bigint NOT NULL,
    id_work bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.autors_works OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16392)
-- Name: experts_works; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.experts_works (
    id_user bigint NOT NULL,
    id_work bigint NOT NULL,
    criterion1 smallint,
    criterion2 smallint,
    criterion3 smallint,
    criterion4 smallint,
    criterion5 smallint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.experts_works OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 16395)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);

ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16401)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 3518 (class 0 OID 0)
-- Dependencies: 212
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;

--
-- TOC entry 213 (class 1259 OID 16402)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);

ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16405)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq AS integer START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 3519 (class 0 OID 0)
-- Dependencies: 214
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;

--
-- TOC entry 215 (class 1259 OID 16406)
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id bigint,
    client_id bigint NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);

ALTER TABLE public.oauth_access_tokens OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16411)
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id bigint NOT NULL,
    client_id bigint NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);

ALTER TABLE public.oauth_auth_codes OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16416)
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_clients (
    id bigint NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(100),
    provider character varying(255),
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.oauth_clients OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16421)
-- Name: oauth_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oauth_clients_id_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.oauth_clients_id_seq OWNER TO postgres;

--
-- TOC entry 3520 (class 0 OID 0)
-- Dependencies: 218
-- Name: oauth_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.oauth_clients_id_seq OWNED BY public.oauth_clients.id;

--
-- TOC entry 219 (class 1259 OID 16422)
-- Name: oauth_personal_access_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_personal_access_clients (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.oauth_personal_access_clients OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16425)
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oauth_personal_access_clients_id_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.oauth_personal_access_clients_id_seq OWNER TO postgres;

--
-- TOC entry 3521 (class 0 OID 0)
-- Dependencies: 220
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;

--
-- TOC entry 221 (class 1259 OID 16426)
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);

ALTER TABLE public.oauth_refresh_tokens OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16429)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);

ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16434)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16439)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 3522 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;

--
-- TOC entry 225 (class 1259 OID 16440)
-- Name: protocol_works; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.protocol_works AS
SELECT
    NULL::character varying(255) AS type,
    NULL::text AS stamp,
    NULL::character varying(255) AS name_work,
    NULL::character varying(255) AS autor,
    NULL::text AS name_subject_area,
    NULL::real AS final_grade,
    NULL::real AS pages_number,
    NULL::character varying AS publisher,
    NULL::smallint AS publishing_year;

ALTER TABLE public.protocol_works OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16444)
-- Name: protocols; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.protocols (
    id_protocol bigint NOT NULL,
    meeting_date date,
    link_protocol_file character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(255) NOT NULL
);

ALTER TABLE public.protocols OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16449)
-- Name: protocols_id_protocol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.protocols_id_protocol_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.protocols_id_protocol_seq OWNER TO postgres;

--
-- TOC entry 3523 (class 0 OID 0)
-- Dependencies: 227
-- Name: protocols_id_protocol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.protocols_id_protocol_seq OWNED BY public.protocols.id_protocol;

--
-- TOC entry 228 (class 1259 OID 16450)
-- Name: subject_areas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subject_areas (
    id_subject_area bigint NOT NULL,
    name_subject_area character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.subject_areas OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 16453)
-- Name: subject_areas_id_subject_area_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subject_areas_id_subject_area_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.subject_areas_id_subject_area_seq OWNER TO postgres;

--
-- TOC entry 3524 (class 0 OID 0)
-- Dependencies: 229
-- Name: subject_areas_id_subject_area_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subject_areas_id_subject_area_seq OWNED BY public.subject_areas.id_subject_area;

--
-- TOC entry 230 (class 1259 OID 16454)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id_user bigint NOT NULL,
    full_name character varying(255) NOT NULL,
    role character varying(255) NOT NULL,
    login character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16459)
-- Name: users_id_user_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_user_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.users_id_user_seq OWNER TO postgres;

--
-- TOC entry 3525 (class 0 OID 0)
-- Dependencies: 231
-- Name: users_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;

--
-- TOC entry 232 (class 1259 OID 16460)
-- Name: users_subject_areas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users_subject_areas (
    id_user bigint NOT NULL,
    id_subject_area bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.users_subject_areas OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 16463)
-- Name: works; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.works (
    id_work bigint NOT NULL,
    name_work character varying(255) NOT NULL,
    language character varying(255),
    creative boolean NOT NULL,
    status character varying(255) NOT NULL,
    final_grade real,
    id_protocol bigint,
    original_percent real,
    link_file_extract_protocol character varying(255) NOT NULL,
    link_text_file character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    link_pdf_file character varying(255),
    type character varying(255),
    link_text_percent1 character varying(255),
    link_text_percent2 character varying(255),
    link_text_percent3 character varying(255),
    link_text_percent4 character varying(255),
    link_text_percent5 character varying(255),
    percent1 real,
    percent2 real,
    percent3 real,
    percent4 real,
    percent5 real,
    publisher character varying,
    publishing_year smallint,
    pages_number real
);

ALTER TABLE public.works OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 16468)
-- Name: works_id_work_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.works_id_work_seq START
WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

ALTER TABLE public.works_id_work_seq OWNER TO postgres;

--
-- TOC entry 3526 (class 0 OID 0)
-- Dependencies: 234
-- Name: works_id_work_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.works_id_work_seq OWNED BY public.works.id_work;

--
-- TOC entry 235 (class 1259 OID 16469)
-- Name: works_subject_areas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.works_subject_areas (
    id_work bigint NOT NULL,
    id_subject_area bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

ALTER TABLE public.works_subject_areas OWNER TO postgres;

--
-- TOC entry 3271 (class 2604 OID 16472)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);

--
-- TOC entry 3272 (class 2604 OID 16473)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);

--
-- TOC entry 3273 (class 2604 OID 16474)
-- Name: oauth_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_clients_id_seq'::regclass);

--
-- TOC entry 3274 (class 2604 OID 16475)
-- Name: oauth_personal_access_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);

--
-- TOC entry 3275 (class 2604 OID 16476)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);

--
-- TOC entry 3276 (class 2604 OID 16477)
-- Name: protocols id_protocol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.protocols ALTER COLUMN id_protocol SET DEFAULT nextval('public.protocols_id_protocol_seq'::regclass);

--
-- TOC entry 3277 (class 2604 OID 16478)
-- Name: subject_areas id_subject_area; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject_areas ALTER COLUMN id_subject_area SET DEFAULT nextval('public.subject_areas_id_subject_area_seq'::regclass);

--
-- TOC entry 3278 (class 2604 OID 16479)
-- Name: users id_user; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);

--
-- TOC entry 3279 (class 2604 OID 16480)
-- Name: works id_work; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works ALTER COLUMN id_work SET DEFAULT nextval('public.works_id_work_seq'::regclass);

--
-- TOC entry 3485 (class 0 OID 16389)
-- Dependencies: 209
-- Data for Name: autors_works; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3486 (class 0 OID 16392)
-- Dependencies: 210
-- Data for Name: experts_works; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3487 (class 0 OID 16395)
-- Dependencies: 211
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3489 (class 0 OID 16402)
-- Dependencies: 213
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.migrations
VALUES (
        1,
        '2023_12_30_015330_create_protocols_table',
        1
    );

INSERT INTO
    public.migrations
VALUES (
        2,
        '2014_10_12_000000_create_users_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        3,
        '2014_10_12_100000_create_password_reset_tokens_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        4,
        '2019_08_19_000000_create_failed_jobs_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        5,
        '2019_12_14_000001_create_personal_access_tokens_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        6,
        '2023_12_19_103446_create_works_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        7,
        '2023_12_30_015312_create_subject_areas_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        8,
        '2023_12_30_015410_create_users_subject_areas_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        9,
        '2023_12_30_015419_create_works_subject_areas_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        10,
        '2023_12_30_015434_create_autors_works_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        11,
        '2023_12_30_015442_create_experts_works_table',
        2
    );

INSERT INTO
    public.migrations
VALUES (
        15,
        '2024_01_07_194337_create_my_works_view',
        3
    );

INSERT INTO
    public.migrations
VALUES (
        16,
        '2016_06_01_000001_create_oauth_auth_codes_table',
        4
    );

INSERT INTO
    public.migrations
VALUES (
        17,
        '2016_06_01_000002_create_oauth_access_tokens_table',
        4
    );

INSERT INTO
    public.migrations
VALUES (
        18,
        '2016_06_01_000003_create_oauth_refresh_tokens_table',
        4
    );

INSERT INTO
    public.migrations
VALUES (
        19,
        '2016_06_01_000004_create_oauth_clients_table',
        4
    );

INSERT INTO
    public.migrations
VALUES (
        20,
        '2016_06_01_000005_create_oauth_personal_access_clients_table',
        4
    );

INSERT INTO
    public.migrations
VALUES (
        22,
        '2024_04_13_130259_create_val_works_view',
        5
    );

--
-- TOC entry 3491 (class 0 OID 16406)
-- Dependencies: 215
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3492 (class 0 OID 16411)
-- Dependencies: 216
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3493 (class 0 OID 16416)
-- Dependencies: 217
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.oauth_clients
VALUES (
        1,
        NULL,
        'Laravel Personal Access Client',
        'afOfgixTijnIgTn74b9DleTJ9wPA7S8lcb8pYPd2',
        NULL,
        'http://localhost',
        true,
        false,
        false,
        '2024-03-20 19:03:32',
        '2024-03-20 19:03:32'
    );

INSERT INTO
    public.oauth_clients
VALUES (
        2,
        NULL,
        'Laravel Password Grant Client',
        'gvAxnJbv0O5cLRhgmnBd8eziIIUsAjmxyKL6R2bJ',
        'users',
        'http://localhost',
        false,
        true,
        false,
        '2024-03-20 19:03:32',
        '2024-03-20 19:03:32'
    );

--
-- TOC entry 3495 (class 0 OID 16422)
-- Dependencies: 219
-- Data for Name: oauth_personal_access_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.oauth_personal_access_clients
VALUES (
        1,
        1,
        '2024-03-20 19:03:32',
        '2024-03-20 19:03:32'
    );

--
-- TOC entry 3497 (class 0 OID 16426)
-- Dependencies: 221
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3498 (class 0 OID 16429)
-- Dependencies: 222
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3499 (class 0 OID 16434)
-- Dependencies: 223
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.personal_access_tokens
VALUES (
        1,
        'App\Models\User',
        1,
        'AppName',
        '896365508ecca54b2f2613519fac56dd019d1316b488629bea893c57aeef20df',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 11:57:08',
        '2024-04-17 11:57:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        2,
        'App\Models\User',
        1,
        'AppName',
        'c7a263fac9fa57541a90ed575c595ff23628b7ff6f75d540ec7ddc08c697c1de',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 11:57:28',
        '2024-04-17 11:57:28'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        3,
        'App\Models\User',
        1,
        'AppName',
        '18622e6c675eccfd282db14c66c40c5272c96c602561243f531502510c4bfe58',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 11:59:21',
        '2024-04-17 11:59:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        4,
        'App\Models\User',
        1,
        'AppName',
        'b755f42c8577196ae30c4ffee21247e161e662048aec7f9195961e5652acbab3',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:01:04',
        '2024-04-17 12:01:04'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        5,
        'App\Models\User',
        1,
        'AppName',
        '6c036a62eee5033bcb0749b1616f43ddeda1d01e9725fde4ca2ce117c513a069',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:05:12',
        '2024-04-17 12:05:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        6,
        'App\Models\User',
        1,
        'AppName',
        '5937ab1f184eacf36148355516b9db9ef1543495d91ae5c1655bbdc7458c81cd',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:05:59',
        '2024-04-17 12:05:59'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        7,
        'App\Models\User',
        1,
        'AppName',
        '75be4ca106dd79337fd1bb6c2e011b7a89e84b0c41dd979b3c35d2ee145ae625',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:17:03',
        '2024-04-17 12:17:03'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        8,
        'App\Models\User',
        1,
        'AppName',
        'c7291b7169be12c10b0daf69f3646bf74c43dad5b19fdda6bd619af26d327af1',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:18:03',
        '2024-04-17 12:18:03'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        9,
        'App\Models\User',
        2,
        'AppName',
        '8a3952f81f736b8f8686d1c24b19552517f8c294e364a4050ee5108b970e61ec',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 12:45:44',
        '2024-04-17 12:45:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        10,
        'App\Models\User',
        1,
        'AppName',
        'd6ed4852a31eeee4024decadb0f06031b1c38552b302a7550e923286415b9a14',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 13:30:49',
        '2024-04-17 13:30:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        11,
        'App\Models\User',
        1,
        'AppName',
        '01f94127acccd61b21fa556d43a6203cfb5ee4e1838126ba3e254221e39385c2',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 13:31:12',
        '2024-04-17 13:31:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        12,
        'App\Models\User',
        1,
        'AppName',
        'ff63c7802ed4f5695e9b3f606f8fb1058bf2a4e9d7816eefa70bf94759c57a36',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 13:31:55',
        '2024-04-17 13:31:55'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        13,
        'App\Models\User',
        1,
        'AppName',
        '06c133447af2edd775d89fcbcac8f3c3a8e7efd017b600e18d7a205d67568c75',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 19:34:47',
        '2024-04-17 19:34:47'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        14,
        'App\Models\User',
        2,
        'AppName',
        'fe37384fcee6f0885b3c8a4dfc6f7e732a34c1b5bd6bf00d83bb3b369169ace7',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 19:40:46',
        '2024-04-17 19:40:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        15,
        'App\Models\User',
        1,
        'AppName',
        'e1a9de615a92dd212824fe6bd32d09d51152499da601812e9fe56f4c5bb239c6',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 19:43:32',
        '2024-04-17 19:43:32'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        16,
        'App\Models\User',
        1,
        'AppName',
        '9074a903da8e2ed9b4b29d0a45962ff29fe3b7f0078596d0cc310317c806a575',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 20:43:13',
        '2024-04-17 20:43:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        17,
        'App\Models\User',
        2,
        'AppName',
        'cb0d57c7948605cb538321a489a2117e1b3ab82867e428e896c37da53226557a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:16:16',
        '2024-04-17 21:16:16'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        18,
        'App\Models\User',
        2,
        'AppName',
        '65a37ce6e32b185d0f1823dcf3f9a85789696d38d309345166e522864af03e4a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:16:40',
        '2024-04-17 21:16:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        19,
        'App\Models\User',
        1,
        'AppName',
        '935e9845d0cabf6422037a2cfe9829ea5113a65a9c47209a9af6d24d949fa3b8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:16:57',
        '2024-04-17 21:16:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        20,
        'App\Models\User',
        2,
        'AppName',
        '7268ce63529fc6332f6b9b8e336163e27dbe43b20489fa2f5c1021b6e2448eb5',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:19:08',
        '2024-04-17 21:19:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        21,
        'App\Models\User',
        1,
        'AppName',
        '888a1220719e4aed78ee231b835672622e27b8fcd0515141ce850572374a7f06',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:20:13',
        '2024-04-17 21:20:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        22,
        'App\Models\User',
        2,
        'AppName',
        '38aa7ab45de63020313db3d42fe929f9bb428f7680951ffb2d16d2b9fc76e22d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:48:38',
        '2024-04-17 21:48:38'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        23,
        'App\Models\User',
        2,
        'AppName',
        'bed7bfe931c4c1c23cf9b08f85dbe1daddbfe8ebbf8975a4dcb6a9064556c381',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:54:08',
        '2024-04-17 21:54:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        24,
        'App\Models\User',
        2,
        'AppName',
        '0a0caaebdd9807a59fa6bb7a8ef092ce1e55720dd4a2e2129fcb3d1c4446878c',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:55:22',
        '2024-04-17 21:55:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        25,
        'App\Models\User',
        3,
        'AppName',
        'e36b4b45c7b71cc41089c268bf59b0d3b35802391de2e8d66eca40c5edd18b10',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 21:56:41',
        '2024-04-17 21:56:41'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        26,
        'App\Models\User',
        3,
        'AppName',
        '7f0c759265d39d3f1b690d7389f74ab94977a25476f26f54dc801a326572a637',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:00:16',
        '2024-04-17 22:00:16'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        27,
        'App\Models\User',
        3,
        'AppName',
        '6465d981b6bd3c746c551d85e447bc6643aa38227e418f5218d41523b73896bd',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:01:37',
        '2024-04-17 22:01:37'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        28,
        'App\Models\User',
        1,
        'AppName',
        'd41d4ea0739331990350e3a327f898e6c9a8077e535e5063b73158e6f8f7c4a3',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:02:01',
        '2024-04-17 22:02:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        29,
        'App\Models\User',
        2,
        'AppName',
        'bcbaf90acc79d154404f8303aed8da5d6c11c0c7d1d8a74a730a8b76943b045d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:02:31',
        '2024-04-17 22:02:31'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        30,
        'App\Models\User',
        3,
        'AppName',
        '98835d22728c328dc4bedabbdbc3d05a19b8ac545340ccaafe8cbf43fb3e84ee',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:02:46',
        '2024-04-17 22:02:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        31,
        'App\Models\User',
        3,
        'AppName',
        '6be02b8c0200ee13077f1f39aa30cca96f18f875c93b808adddeaf2a51d11f55',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:03:54',
        '2024-04-17 22:03:54'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        32,
        'App\Models\User',
        1,
        'AppName',
        '33e040ffc9afa9aacca9cad37e63cf59f73fad3e80bd41b51b3ff726390321a7',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:05:23',
        '2024-04-17 22:05:23'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        33,
        'App\Models\User',
        2,
        'AppName',
        '6ea53e593eda4b4ec5b001c7d5b48fe2c15d1411f8596da7127084af3009c6c1',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:05:42',
        '2024-04-17 22:05:42'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        34,
        'App\Models\User',
        3,
        'AppName',
        '9054f9fb8eaf66ffa124345fbdca2298114d5bb37e75a48375f973803268f16f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:06:21',
        '2024-04-17 22:06:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        35,
        'App\Models\User',
        3,
        'AppName',
        '3e6725d17e65a1d67573482b00b646fad6f68b553777f09c8558f568116176d6',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:07:19',
        '2024-04-17 22:07:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        36,
        'App\Models\User',
        3,
        'AppName',
        '514303dab3cc1fca881ffec873b35026f8b6fb3430bf84ed075d74768039e487',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:10:02',
        '2024-04-17 22:10:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        37,
        'App\Models\User',
        3,
        'AppName',
        '135bc995eab1fba589f46835a038382ff0bb5a1174e1937b5b26fb090a3e7fc1',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:11:10',
        '2024-04-17 22:11:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        38,
        'App\Models\User',
        1,
        'AppName',
        '55bc3f17f15c1b71b3d69cf4a1ce6abe9f3821fe52866d3b67375d6a7190641e',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:17:01',
        '2024-04-17 22:17:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        39,
        'App\Models\User',
        1,
        'AppName',
        '96ea78e0599be27b476261c680972620751813c323c52e6c9ebefeec5150fae5',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:19:13',
        '2024-04-17 22:19:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        40,
        'App\Models\User',
        3,
        'AppName',
        '61d1273cbfab620a8a85d2384f9e4bf0a5b87bbee05de8b110be620487fb2bef',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:25:55',
        '2024-04-17 22:25:55'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        41,
        'App\Models\User',
        1,
        'AppName',
        'c61d677ee8dfcd64400b08a6395f41ab563a62e66f388542e037c57845abc8b0',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:30:01',
        '2024-04-17 22:30:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        42,
        'App\Models\User',
        1,
        'AppName',
        '0baf5ce805430a05e396ba364e1fd3dda7a2bf18094cd7785fa52bcd27c35285',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:33:12',
        '2024-04-17 22:33:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        43,
        'App\Models\User',
        1,
        'AppName',
        '9c2e635bdc83d41912f081bb1c68383395bb9034cbb2f23f813afccb2ae4a21f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-17 22:34:20',
        '2024-04-17 22:34:20'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        44,
        'App\Models\User',
        1,
        'AppName',
        '56493e55002f383c818dfc159431cb4be863a3315648212535cfa554a9d26559',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 21:00:39',
        '2024-04-18 21:00:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        45,
        'App\Models\User',
        2,
        'AppName',
        '837cd4df3220bc110abbdea39b832dc0ef5f57a59c14088f04b908c38bdc781d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:14:08',
        '2024-04-18 22:14:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        46,
        'App\Models\User',
        3,
        'AppName',
        'e057c7f099d0e2c0305c17fb5da0a0a4f11958d8a885abf12f38118d0c5683fc',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:17:19',
        '2024-04-18 22:17:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        47,
        'App\Models\User',
        2,
        'AppName',
        '56e03f62ebe16016ed4c6b114873bf697bb08cd3e006a21a9d8d159958cf60dc',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:21:06',
        '2024-04-18 22:21:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        48,
        'App\Models\User',
        1,
        'AppName',
        '82038f87a4fc8086b0c80f7f5a05a43fba6cdccee7ec0458b6e0e29771a621e8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:23:40',
        '2024-04-18 22:23:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        49,
        'App\Models\User',
        2,
        'AppName',
        '480c277d1d42028a7aaa422f59c6fb400eda49d4a5cc97149ceb7377e1089f23',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:31:37',
        '2024-04-18 22:31:37'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        50,
        'App\Models\User',
        2,
        'AppName',
        'bafc504f5576ab04cb488ffddc77df4df6e1548c2a92bf9e156a0c0373b4a2d2',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:49:43',
        '2024-04-18 22:49:43'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        51,
        'App\Models\User',
        2,
        'AppName',
        '8a76bd2b67789363e1d8c3179be7d2cb34942c843cb805219dfbf05c079a9d70',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:53:20',
        '2024-04-18 22:53:20'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        52,
        'App\Models\User',
        2,
        'AppName',
        '3d0b251fc919f3b9770c4410d01e3828911d6015c5b22164193a73396c7d2200',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:53:58',
        '2024-04-18 22:53:58'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        53,
        'App\Models\User',
        2,
        'AppName',
        '9d8c4fa058784695215826176b7d256cb8c1d9e9116116d66f89658a0b5eed93',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:56:22',
        '2024-04-18 22:56:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        54,
        'App\Models\User',
        2,
        'AppName',
        '715f2ff5d758136bc73bd8f4372cd01cabacb85e783f0821e1f11de2d6b782d5',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 22:58:49',
        '2024-04-18 22:58:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        55,
        'App\Models\User',
        2,
        'AppName',
        '0377efa49e66a5fe36e760f6be3a73bcd0ba936350b249fc5e2f71887d55781f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 23:11:44',
        '2024-04-18 23:11:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        56,
        'App\Models\User',
        2,
        'AppName',
        '28805dc9a90b274b63732c9d3a3c9ddfed8e381376f238092aa8b638b5853b2e',
        '["*"]',
        NULL,
        NULL,
        '2024-04-18 23:18:37',
        '2024-04-18 23:18:37'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        57,
        'App\Models\User',
        2,
        'AppName',
        '481d48df48572b711fa2f2b13bb7ef3f6779a0ac0f016e8f98469705d730f946',
        '["*"]',
        NULL,
        NULL,
        '2024-04-20 14:33:18',
        '2024-04-20 14:33:18'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        58,
        'App\Models\User',
        3,
        'AppName',
        '44aedfea0365a78494697b1ae59a78f724fa5d26c863d11a70667715f644b87f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-20 15:17:46',
        '2024-04-20 15:17:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        59,
        'App\Models\User',
        2,
        'AppName',
        '46bcad35822e17d387f85d46078f50cec4e5b73bf939548813770c6c4751795a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-20 15:31:44',
        '2024-04-20 15:31:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        60,
        'App\Models\User',
        2,
        'AppName',
        'cc2b55da271e954930d4e8b2b656531c2244b6fadd1ea70d1a66c328bf83bfce',
        '["*"]',
        NULL,
        NULL,
        '2024-04-20 15:40:07',
        '2024-04-20 15:40:07'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        61,
        'App\Models\User',
        1,
        'AppName',
        '9e3952f06d3968b91bc0313f6a6735c958825bf384d471f7aa3e782452b56cca',
        '["*"]',
        NULL,
        NULL,
        '2024-04-20 15:42:49',
        '2024-04-20 15:42:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        62,
        'App\Models\User',
        1,
        'AppName',
        '84e7b3fbe25935a8820000eb8ed58971e6bcd3e315e63168681b34205812562a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-22 12:28:01',
        '2024-04-22 12:28:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        63,
        'App\Models\User',
        3,
        'AppName',
        '29ca63546de9ca6f288ed6bc9b50bae2e7657bcc1129494beba978b9ea9f0bfa',
        '["*"]',
        NULL,
        NULL,
        '2024-04-22 12:33:19',
        '2024-04-22 12:33:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        64,
        'App\Models\User',
        2,
        'AppName',
        'd8e23ceb9fe0ef4b49d6bbcdac4f442fcfab91cebc829927985db3a498abf4d5',
        '["*"]',
        NULL,
        NULL,
        '2024-04-22 12:33:40',
        '2024-04-22 12:33:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        65,
        'App\Models\User',
        2,
        'AppName',
        '5a423fff85b5dc970e3e42978aa246b9dd0825123433b97a49299f1eece8ee7f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-22 12:34:19',
        '2024-04-22 12:34:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        66,
        'App\Models\User',
        2,
        'AppName',
        '1798131535111b9e99dab35c9cd1125d0e69ae234b33608061a01eefb585821c',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 10:47:54',
        '2024-04-23 10:47:54'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        67,
        'App\Models\User',
        3,
        'AppName',
        '2744527ce7a735bedf664705a951145eaf4de03990bc1fd1c10783309d1e6366',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:09:23',
        '2024-04-23 11:09:23'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        68,
        'App\Models\User',
        2,
        'AppName',
        'c29acd109217b6f9854a3bca16d5ececdefb70b4978e012f875a57db287d2232',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:48:31',
        '2024-04-23 11:48:31'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        69,
        'App\Models\User',
        2,
        'AppName',
        'd377c3b205f0009b6e76005ae1d383d4a76da6461ec1ffb9359ce0e5aa902a36',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:49:47',
        '2024-04-23 11:49:47'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        70,
        'App\Models\User',
        3,
        'AppName',
        'f3abe22c195e0ef8722927be18e371c785baffed81482330ee7a455cf40fbe9e',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:50:43',
        '2024-04-23 11:50:43'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        71,
        'App\Models\User',
        3,
        'AppName',
        '890ef8d6c5216e6efabc3f3537af3ec03be60c7ee8d541e799eb8ad358ec747a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:51:21',
        '2024-04-23 11:51:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        72,
        'App\Models\User',
        3,
        'AppName',
        '29c3b7133c6321e7a5ff3a355bd24a98fd1f9a8aae2996dcf1cd00ea6e5dc68d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:54:39',
        '2024-04-23 11:54:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        73,
        'App\Models\User',
        2,
        'AppName',
        '47e47e30991c0252295dde4e1262506d79a1b548953bfb144844da3d0aa75bf8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:55:07',
        '2024-04-23 11:55:07'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        74,
        'App\Models\User',
        3,
        'AppName',
        '0d926f21fc8e50bea80eb7df47573dd2e5d45d83ff340c938a623a689f56a543',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 11:55:56',
        '2024-04-23 11:55:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        75,
        'App\Models\User',
        2,
        'AppName',
        '05e98edf0dd1826f5ba711353451875d0211df9a97eb36dcadf825a312f08785',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:01:14',
        '2024-04-23 12:01:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        76,
        'App\Models\User',
        3,
        'AppName',
        'a02bf31239170ca3640f338fd88244577e6b13b9670eb418425e5297cedfe816',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:01:39',
        '2024-04-23 12:01:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        77,
        'App\Models\User',
        2,
        'AppName',
        '2a8ec7f73fc9447f9167994935500b6992f7126fc42dfdfb287280f7739b82f8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:02:03',
        '2024-04-23 12:02:03'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        78,
        'App\Models\User',
        3,
        'AppName',
        'f929e0dd085bf8e73a695761dc80ce2c94161bba28cb7f0316bdbf7e914d0fb0',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:03:34',
        '2024-04-23 12:03:34'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        79,
        'App\Models\User',
        2,
        'AppName',
        'ca9684fafcec126455235d820bd08340508a4ee20ed800358a7de25392ab000f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:06:06',
        '2024-04-23 12:06:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        80,
        'App\Models\User',
        3,
        'AppName',
        '0a363af4b085f97e6aecf89291e102552f46739871240e2d0645e0df3c57ecf2',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:17:19',
        '2024-04-23 12:17:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        81,
        'App\Models\User',
        3,
        'AppName',
        'e9ffcd2dd3fee86718359ac9a27771ccd7a3ed9a6f69ad1dd6c91c04e6d1e2b8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:19:09',
        '2024-04-23 12:19:09'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        82,
        'App\Models\User',
        2,
        'AppName',
        '56dbc2838c1bf4ac02071426e7c310f271ce36976e0c46c6a2aa38d6fb30d083',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:19:46',
        '2024-04-23 12:19:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        83,
        'App\Models\User',
        3,
        'AppName',
        'f1e869d8ede424643fe59cb5ddbf0bfbd1bb60ef46f74d8c8eb9b49f429c1c1e',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:20:19',
        '2024-04-23 12:20:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        84,
        'App\Models\User',
        2,
        'AppName',
        'dfc746f1e192720f0300c7fdde6568d25c11b8267138869c88d5908ec9b3a25c',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:20:49',
        '2024-04-23 12:20:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        85,
        'App\Models\User',
        1,
        'AppName',
        '35b90eb7f752f60a229587460e7ec50dbbc7caebd6d018b8bcea9e57d896954a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:23:05',
        '2024-04-23 12:23:05'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        86,
        'App\Models\User',
        2,
        'AppName',
        '015d34b174f9c692d26925810e63027c6afb6e569d990b297eeed19431f72c36',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 12:23:48',
        '2024-04-23 12:23:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        87,
        'App\Models\User',
        2,
        'AppName',
        '0a2332816f361aff9ea996c33031e8b0e28d475b5bcf3a9dd8d40c895cc67d5f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 19:14:59',
        '2024-04-23 19:14:59'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        88,
        'App\Models\User',
        3,
        'AppName',
        '5a7c195a727cab00a4a7fa301dd53f1e70622b9fe658a7c280ee36464e96082a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 20:02:30',
        '2024-04-23 20:02:30'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        89,
        'App\Models\User',
        2,
        'AppName',
        'a6cffe727be7307adbff1111a312955bdf36e9554adb9bd5fd8705ea73d248ce',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 20:05:48',
        '2024-04-23 20:05:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        90,
        'App\Models\User',
        2,
        'AppName',
        'c3d02b8a3c89d13c1e8f764d5719f983f2a057ac192ac782961bf3c0d5ba2018',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 20:07:30',
        '2024-04-23 20:07:30'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        91,
        'App\Models\User',
        2,
        'AppName',
        '744dbbcfaebf270ddc919dc06a12ad2c0de666d5662a1173d917861d2fd130cf',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 21:40:11',
        '2024-04-23 21:40:11'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        92,
        'App\Models\User',
        2,
        'AppName',
        '714641f3080b1ed92504094dcea2e7f77b925b79e9a8c42778bae29cdb6222a1',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 22:26:26',
        '2024-04-23 22:26:26'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        93,
        'App\Models\User',
        2,
        'AppName',
        '177874d9c635f2d916afc10d2fd66a2868df199150768ffbf8fcc94e1500ad34',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 22:43:26',
        '2024-04-23 22:43:26'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        94,
        'App\Models\User',
        2,
        'AppName',
        'eda9b00bd432a3ceb3984321825f0a056d52ee098001009e5eeef57912b1f427',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 22:44:17',
        '2024-04-23 22:44:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        95,
        'App\Models\User',
        3,
        'AppName',
        '8c5a901983c954599629aa4dbb937fe5bc92f4d15494094d2b66c4ce841e5b8b',
        '["*"]',
        NULL,
        NULL,
        '2024-04-23 22:52:02',
        '2024-04-23 22:52:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        96,
        'App\Models\User',
        2,
        'AppName',
        '4eb790ce46af8e655f08786faf42db9912f208e6da87df73d59a95aad0f3f118',
        '["*"]',
        NULL,
        NULL,
        '2024-04-26 20:53:15',
        '2024-04-26 20:53:15'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        97,
        'App\Models\User',
        3,
        'AppName',
        '613c5c24b64010e2bed5f1ebf66927f78e07129bf4882135c978abafa2fd37a6',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 10:06:57',
        '2024-04-27 10:06:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        98,
        'App\Models\User',
        2,
        'AppName',
        'baddafa020dc16e245a0607612c2f05217fa9aa478b2773510a48e2f49dfce9d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 10:09:56',
        '2024-04-27 10:09:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        99,
        'App\Models\User',
        3,
        'AppName',
        '7bc366f8357e85cfad40315170ff5245dcf4efa868fc3027fade53eb8b75a8a4',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 12:24:06',
        '2024-04-27 12:24:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        100,
        'App\Models\User',
        3,
        'AppName',
        '4cb53c7a69a6e6500fa64b424986c219c015703610ae949da4fdd50b2b1cf89f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 13:04:14',
        '2024-04-27 13:04:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        101,
        'App\Models\User',
        3,
        'AppName',
        '530f41e304c3764821d6fcf9da91ed53e6b521e358c3888014f9842badd6b15a',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 21:37:04',
        '2024-04-27 21:37:04'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        102,
        'App\Models\User',
        2,
        'AppName',
        '45757c1e8b16b9c373fc92940364146684d3431008643f2d3e1f3f42022fe00d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 23:22:01',
        '2024-04-27 23:22:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        103,
        'App\Models\User',
        3,
        'AppName',
        '04b43f92a37f707b0aab42620f96f7bf2110a2b5aebad31394c549fb3d083607',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 23:32:15',
        '2024-04-27 23:32:15'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        104,
        'App\Models\User',
        2,
        'AppName',
        '9bf46a08691063d4a81fdf48a542b0b7907cff500507cdd895ec020eaaaf2a3d',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 23:43:13',
        '2024-04-27 23:43:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        105,
        'App\Models\User',
        3,
        'AppName',
        '963080ed8230c20a6c7e6efa17d450a6220552fa2393474133d1a0211da2c700',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 23:48:25',
        '2024-04-27 23:48:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        106,
        'App\Models\User',
        2,
        'AppName',
        '70d7c7c21469df4e35c1e5ce526434eb407c7b7cf7dea704ea4e16b2badfb976',
        '["*"]',
        NULL,
        NULL,
        '2024-04-27 23:59:47',
        '2024-04-27 23:59:47'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        107,
        'App\Models\User',
        1,
        'AppName',
        '94d77e0c52f0e2b9a916c5d77172b65e215ced31d3c19f05a310487b08c70ad1',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 20:06:28',
        '2024-04-28 20:06:28'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        108,
        'App\Models\User',
        7,
        'AppName',
        'b0b31640090216a3a39a275c4e10f41cca30f257e9b798c1103eb9b506d385b4',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 20:09:24',
        '2024-04-28 20:09:24'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        109,
        'App\Models\User',
        7,
        'AppName',
        '348f12c82ecf681e5deecbac4088ac9299662eed12447c447de35ec3234ddbba',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 20:09:57',
        '2024-04-28 20:09:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        110,
        'App\Models\User',
        8,
        'AppName',
        'bb99d501a4f2eb699b80bb19f060e5ef902c81288efeab8411efbe468cb29570',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 20:10:15',
        '2024-04-28 20:10:15'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        111,
        'App\Models\User',
        7,
        'AppName',
        'b2806715cb7988c4b6515df7e3aa846e145c3269fc6e1c5d6e058edcb71876e7',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 21:01:34',
        '2024-04-28 21:01:34'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        112,
        'App\Models\User',
        8,
        'AppName',
        'ade2a6e9af4e5b7156d0c648e21531c631e50b654ba49bf2c9d876ae63a09d8f',
        '["*"]',
        NULL,
        NULL,
        '2024-04-28 22:09:50',
        '2024-04-28 22:09:50'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        113,
        'App\Models\User',
        8,
        'AppName',
        '4620bb1c3bc6734c2fd056a5d5bb509b5d02ad5244ae7f85101628c30bceaca8',
        '["*"]',
        NULL,
        NULL,
        '2024-04-29 13:08:34',
        '2024-04-29 13:08:34'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        114,
        'App\Models\User',
        8,
        'AppName',
        'b82111eb97895ee1bfef715ccabe6dee0c435be004730afc14a96aec8fb91b03',
        '["*"]',
        NULL,
        NULL,
        '2024-04-30 18:32:36',
        '2024-04-30 18:32:36'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        115,
        'App\Models\User',
        8,
        'AppName',
        '1de74800dfbc12437efbe356f10688b1468fa99d4dab4a01c00959d2801a1290',
        '["*"]',
        NULL,
        NULL,
        '2024-05-01 12:00:12',
        '2024-05-01 12:00:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        116,
        'App\Models\User',
        8,
        'AppName',
        'b4b1e068d16b2f98819fa999e7fa98eeaff89a41f7417e3644ecd80756547fac',
        '["*"]',
        NULL,
        NULL,
        '2024-05-01 20:38:10',
        '2024-05-01 20:38:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        117,
        'App\Models\User',
        8,
        'AppName',
        '1c97906641a9cf757a701d0cea79cdf2a8e0b737b13723749d5a54e1c11a5f47',
        '["*"]',
        NULL,
        NULL,
        '2024-05-02 17:22:38',
        '2024-05-02 17:22:38'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        118,
        'App\Models\User',
        7,
        'AppName',
        '26d2dfe6452a8ee276209bf2cba09ed7ac19368a7916b8db4c3efb7fef1651ff',
        '["*"]',
        NULL,
        NULL,
        '2024-05-02 17:54:04',
        '2024-05-02 17:54:04'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        119,
        'App\Models\User',
        1,
        'AppName',
        '48b6bc3291df7a79a230b52a2fff7eb5a15cffbb62b161256b84ba703704bb9d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-02 20:46:57',
        '2024-05-02 20:46:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        120,
        'App\Models\User',
        1,
        'AppName',
        'b4d067ea09dc36bc333a4106d7190d7b4a74615d0d3dc707c835016f1c6d4c8b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-02 21:28:53',
        '2024-05-02 21:28:53'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        121,
        'App\Models\User',
        8,
        'AppName',
        '4d36ed808daf77263bd7e72a7e24abdae47b79a44dfa3529ebddc09bb3b68437',
        '["*"]',
        NULL,
        NULL,
        '2024-05-03 11:30:53',
        '2024-05-03 11:30:53'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        122,
        'App\Models\User',
        7,
        'AppName',
        'c56cb9886c8696f8b5676bbc1bcab670551dc576fb3dc0b4b104e920407e38e1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-03 12:04:35',
        '2024-05-03 12:04:35'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        123,
        'App\Models\User',
        2,
        'AppName',
        'b1e352bb6f4e732a7367a733bd415bcd48ece13f58b1ee57553b9f679d38becc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-03 12:26:04',
        '2024-05-03 12:26:04'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        124,
        'App\Models\User',
        8,
        'AppName',
        '0a0242495258c7fc762fbaaf2e35f56e756a39f227f2907a2386f57500502496',
        '["*"]',
        NULL,
        NULL,
        '2024-05-03 22:23:31',
        '2024-05-03 22:23:31'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        125,
        'App\Models\User',
        8,
        'AppName',
        '565c57baa54aa3fd96b5977b595054971ac3c83559cc9f862e84ea6de81dc91e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-03 23:24:10',
        '2024-05-03 23:24:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        126,
        'App\Models\User',
        8,
        'AppName',
        'bb42b4b714a92652d0b7f7bab7f589abdefca05be62a6015fe1009005d0e1823',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 12:18:52',
        '2024-05-04 12:18:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        127,
        'App\Models\User',
        1,
        'AppName',
        'fa0246903b6fcc49f01179e641dc4d7f23d04d702f4d3895f1a8a8e562f6a6e8',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 13:37:36',
        '2024-05-04 13:37:36'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        128,
        'App\Models\User',
        8,
        'AppName',
        '0e1a580cff1f0213b9572becc157bb13191cbdcd9ae1c392d7cf0e752cc856b2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 13:37:58',
        '2024-05-04 13:37:58'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        129,
        'App\Models\User',
        8,
        'AppName',
        '6920425e3e062773301b2a3c0b6e842329c2cdbf00d1873b54fe3d2f6ba74a81',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 14:37:36',
        '2024-05-04 14:37:36'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        130,
        'App\Models\User',
        8,
        'AppName',
        '6fdf86daf2ff30ecbcb01a88c828b523659534771e3244db4bd036a1d8307c97',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 14:38:08',
        '2024-05-04 14:38:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        131,
        'App\Models\User',
        7,
        'AppName',
        '43ce692a82d1248fb56da87e16a3711c75e761e467d128e13cd847b9bf64ea45',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 14:39:42',
        '2024-05-04 14:39:42'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        132,
        'App\Models\User',
        8,
        'AppName',
        'ff08aa228ea3690a6739d4a5f4a23ff9c23851fb2760967ad02f010d3678ece1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 15:25:59',
        '2024-05-04 15:25:59'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        133,
        'App\Models\User',
        8,
        'AppName',
        'af71f598b7161a72bde5b26efd0718bec9b417a650bc04e9d9b92201411d29c3',
        '["*"]',
        NULL,
        NULL,
        '2024-05-04 22:09:14',
        '2024-05-04 22:09:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        134,
        'App\Models\User',
        8,
        'AppName',
        '6b675ef4c9aa06aec9bc23e8ec487bc05aaa86007be12174c3876e2e6352a3e6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-05 22:04:13',
        '2024-05-05 22:04:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        135,
        'App\Models\User',
        8,
        'AppName',
        '1e2c175d862cd77da2d57e97790e075fc84f1e64559d2b648589ab4619f5db21',
        '["*"]',
        NULL,
        NULL,
        '2024-05-05 22:09:27',
        '2024-05-05 22:09:27'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        136,
        'App\Models\User',
        8,
        'AppName',
        '082f91156919201942f5412e149a51e3b5c842c856a8f3f8cc5c1f9e15674e92',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 11:54:02',
        '2024-05-07 11:54:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        137,
        'App\Models\User',
        8,
        'AppName',
        'cedac2f83b0f30765309138e85cf5ed55ef894d177731a402044ec2369c3b7ec',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 12:38:27',
        '2024-05-07 12:38:27'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        138,
        'App\Models\User',
        7,
        'AppName',
        '3f58abe51c8938fa9744c347312da319f265bd61167cd56590d294692f2559dc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 12:51:44',
        '2024-05-07 12:51:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        139,
        'App\Models\User',
        2,
        'AppName',
        '171b436ddfd4ffb0a2b0579335ac4b11bf3a23d43c414ea86d4421477032df1f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 12:52:02',
        '2024-05-07 12:52:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        140,
        'App\Models\User',
        7,
        'AppName',
        'c655b86a71583f446e7d8b3a14ee03cacd79f294b8906dfcb781ae81eb18e4e6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 15:08:52',
        '2024-05-07 15:08:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        141,
        'App\Models\User',
        7,
        'AppName',
        '7d3a9f2e5211206e4c0ee17ac6bc715a02da7b39e0deb1fb0253ddde1d92445d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 18:27:00',
        '2024-05-07 18:27:00'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        142,
        'App\Models\User',
        7,
        'AppName',
        'a118cff10fe5f2aeb1aad77df2c9ba4b5400fe2e32fc6ceaa838af973d7e45eb',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 18:27:28',
        '2024-05-07 18:27:28'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        143,
        'App\Models\User',
        8,
        'AppName',
        '40b7ccd83dfd2fa20e668609c55ec1c69a7d22eefb539451d358341886a318a2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 21:34:47',
        '2024-05-07 21:34:47'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        144,
        'App\Models\User',
        8,
        'AppName',
        '2f5f3955a329ab9614f76f54d2d812c06726ec8279339ef6f18c4d939fe4e647',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 22:20:30',
        '2024-05-07 22:20:30'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        145,
        'App\Models\User',
        2,
        'AppName',
        '95dc040f2686ce8d31aedfbc46d92675b645fe7e52f4a48b761218cfa2b40084',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 22:31:40',
        '2024-05-07 22:31:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        146,
        'App\Models\User',
        7,
        'AppName',
        'c28fb7508bf5d3cd92db6ceed3514db6d3a47f75835b2cebf5783205f3ecda05',
        '["*"]',
        NULL,
        NULL,
        '2024-05-07 22:45:45',
        '2024-05-07 22:45:45'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        147,
        'App\Models\User',
        8,
        'AppName',
        'ab10d79cb3ec332dc053ec8d0e8dc6c30ea9c8eec25a7a768a38788d7aac500e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 12:17:25',
        '2024-05-08 12:17:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        148,
        'App\Models\User',
        2,
        'AppName',
        'a5bf775961b1010fc997ef2e56559eb3fefaf74df65140de4cd01667cf7d7502',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 12:50:58',
        '2024-05-08 12:50:58'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        149,
        'App\Models\User',
        7,
        'AppName',
        'bf9186a5f6a595412f60bf5731e54b0ce88508e382b62a7eaa1e3c4c73621a36',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 12:51:14',
        '2024-05-08 12:51:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        150,
        'App\Models\User',
        7,
        'AppName',
        'e6373a04213fa944617cf2e26c2f1e7e8f34d8ce1f46bf6f4c2f45b4ebc2b3bc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 21:32:37',
        '2024-05-08 21:32:37'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        151,
        'App\Models\User',
        8,
        'AppName',
        'ae90bea30dcb9efcbfc2f1036e86fda01f44ba2f584491b123457cc4a3dde7d7',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 21:32:39',
        '2024-05-08 21:32:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        152,
        'App\Models\User',
        7,
        'AppName',
        '37d015b6afcd1bcc92ec9bb32381943d1baf1c087ce2f514a23975e2c88dbfde',
        '["*"]',
        NULL,
        NULL,
        '2024-05-08 21:42:24',
        '2024-05-08 21:42:24'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        153,
        'App\Models\User',
        2,
        'AppName',
        '9f3b82c3b73a652882fb86127f172c0f125036d32ec9f944f9ddd5e33288049b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-09 00:22:45',
        '2024-05-09 00:22:45'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        154,
        'App\Models\User',
        8,
        'AppName',
        '6cb253bd2a9b98296f55ef97598b5ef18d203c3c5925c05a502c89fc09244b46',
        '["*"]',
        NULL,
        NULL,
        '2024-05-10 11:58:09',
        '2024-05-10 11:58:09'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        155,
        'App\Models\User',
        1,
        'AppName',
        'ba88136866b419a6788b94d4066a059463dbcffa39b0848e7eddc31d7ec00cbc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-10 12:04:11',
        '2024-05-10 12:04:11'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        156,
        'App\Models\User',
        8,
        'AppName',
        '3b51bb241c901fcad1f58611ada81d2c914af710c73af4cdc2e07dc463efe229',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 11:12:25',
        '2024-05-13 11:12:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        157,
        'App\Models\User',
        7,
        'AppName',
        '6cc9bdfd6ee7acd87ec58f4bfdf302d813d9a020d7f94623553da19e44b96308',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 11:18:27',
        '2024-05-13 11:18:27'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        158,
        'App\Models\User',
        8,
        'AppName',
        '08c2cf1044428c8bb8919928ce5d872b5000d33d9894c6c6fa2e65bd157e9b91',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 11:48:26',
        '2024-05-13 11:48:26'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        159,
        'App\Models\User',
        8,
        'AppName',
        'a6417f0f429f9970b5da1eb7a1988964f159c2c2e954ca7d0500e118fa57f294',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 12:03:59',
        '2024-05-13 12:03:59'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        160,
        'App\Models\User',
        8,
        'AppName',
        'a581908036413c17a2dc59d3abdd79770466b00fe2600a09aa0cf61fbb7c0f60',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 12:04:12',
        '2024-05-13 12:04:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        161,
        'App\Models\User',
        8,
        'AppName',
        'b764706e0662d7fd2c3bdcbd6ef8d1dcab436679deaf4bc44513cd42535c6aed',
        '["*"]',
        NULL,
        NULL,
        '2024-05-13 21:34:25',
        '2024-05-13 21:34:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        162,
        'App\Models\User',
        8,
        'AppName',
        'c2e87ccb54f6346df11ef54d9afcaafddb6c68c92de6cc3c9ac5b5ff358c3f6f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:35:33',
        '2024-05-14 11:35:33'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        163,
        'App\Models\User',
        8,
        'AppName',
        '67150aa0561e81f3b0ef51743c0c27927a7967b9bdab00d5ca2a9847cf8facee',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:42:30',
        '2024-05-14 11:42:30'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        164,
        'App\Models\User',
        8,
        'AppName',
        'ec68d440c961a5e7112c84ec301b2499e6f9df4b29c0b73294a799464b9cb4eb',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:43:38',
        '2024-05-14 11:43:38'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        165,
        'App\Models\User',
        8,
        'AppName',
        '22adec8d9a4e1ea0ec034175ec5eb1fbf382ce1b6146ae89550976ade6089295',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:46:11',
        '2024-05-14 11:46:11'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        166,
        'App\Models\User',
        8,
        'AppName',
        '47af4e1a0c7919a4b97efec41ecc7121c1fb834bf529a743fee42d9e77cd45b8',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:46:52',
        '2024-05-14 11:46:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        167,
        'App\Models\User',
        8,
        'AppName',
        '56290ea710bd1915e552dbac82ca292f6869af4c569afe6f31fe5eab2b47d18a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 11:58:28',
        '2024-05-14 11:58:28'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        168,
        'App\Models\User',
        7,
        'AppName',
        'a7a4ec6c5175e7fe541dbd5304a758dcc38810e8311aab43548a61cec3009c8c',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 12:21:54',
        '2024-05-14 12:21:54'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        169,
        'App\Models\User',
        2,
        'AppName',
        '09b04513fe1631bf58a57cc32ce19d58829800b96a9a5228cafcc9a4d80e05d4',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 15:55:57',
        '2024-05-14 15:55:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        170,
        'App\Models\User',
        2,
        'AppName',
        'c6df717a50b04dbe2cecd067dcc9fd4d4519a9a8f8eb24ba644a40c3aef05721',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 15:58:09',
        '2024-05-14 15:58:09'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        171,
        'App\Models\User',
        2,
        'AppName',
        '39b532f59cf554d203df4112c60d5d2edd506f918422f06b96030f4c75d8b06d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 16:01:31',
        '2024-05-14 16:01:31'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        172,
        'App\Models\User',
        2,
        'AppName',
        '9b5534706e52b664a08901ecdb52bb5f7d0d0ffbe2bf26eb259a1bf74dedb125',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 16:02:07',
        '2024-05-14 16:02:07'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        173,
        'App\Models\User',
        2,
        'AppName',
        '13c450a48eeea1876dca6005dfd906e312e426ef0e81afa6d79177597d51c849',
        '["*"]',
        NULL,
        NULL,
        '2024-05-14 16:02:46',
        '2024-05-14 16:02:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        174,
        'App\Models\User',
        8,
        'AppName',
        'd5a889d7d8e2254f08eb0fef300baac879c2cb18814085eccfedf65283764a2a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-15 11:16:48',
        '2024-05-15 11:16:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        175,
        'App\Models\User',
        8,
        'AppName',
        '4643c9f5f6ab01cc0da91e49d08da993fe0076b0c24834b10189574bf4787a21',
        '["*"]',
        NULL,
        NULL,
        '2024-05-16 16:24:39',
        '2024-05-16 16:24:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        176,
        'App\Models\User',
        1,
        'AppName',
        'f21845fd081752e6a78284052a9703f86d5b6c863fe36fbfd49be960ae2c5f3f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-16 16:56:39',
        '2024-05-16 16:56:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        177,
        'App\Models\User',
        1,
        'AppName',
        'e4b638bc0d3f86829c8f9f6549caf2b08664dfbe89669c27b0c1c09e1afd18d3',
        '["*"]',
        NULL,
        NULL,
        '2024-05-16 20:32:33',
        '2024-05-16 20:32:33'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        178,
        'App\Models\User',
        8,
        'AppName',
        '83f21b624ff7954fd956c4ce1f9cdbf75aa499e67052322192b7820b504b4f8e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:00:39',
        '2024-05-17 10:00:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        179,
        'App\Models\User',
        2,
        'AppName',
        'b27145f40af56e7b566579ddd7e7a839c9847b7bdd173650aab2ca41a582b19e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:01:46',
        '2024-05-17 10:01:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        180,
        'App\Models\User',
        8,
        'AppName',
        '191c820e746c50fd63389ce3d4d87dc2ccb410690f916ba64f2c201978181b1e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:02:48',
        '2024-05-17 10:02:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        181,
        'App\Models\User',
        8,
        'AppName',
        '099f73ceb4578c715dcc78ce17eae1853394b1e30ef932bd9f1a5845044a45ad',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:13:17',
        '2024-05-17 10:13:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        182,
        'App\Models\User',
        8,
        'AppName',
        '6ba1aa86f39488780077ac16e7c09c4790d347874bc8cd0c5be95f685186456f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:18:10',
        '2024-05-17 10:18:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        183,
        'App\Models\User',
        8,
        'AppName',
        'b0a9fc5e0c413c37a3de40a56a09cbc27257613ed01dbca3cca4bb1b16f4409b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:19:33',
        '2024-05-17 10:19:33'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        184,
        'App\Models\User',
        8,
        'AppName',
        '1fb826f52065c8f79b8e514095cf5b82f5482d22b7b157d34c0613e42c7e962a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:20:43',
        '2024-05-17 10:20:43'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        185,
        'App\Models\User',
        8,
        'AppName',
        '7442b1ea9ce633b6daa063f20f9419b5726c667d24fe53ceb4f8199999142c81',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:21:05',
        '2024-05-17 10:21:05'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        186,
        'App\Models\User',
        8,
        'AppName',
        '2699369173e9a3a86d015d3e08049c2618e63f1abf01db3cb9f823cc5e6f4e15',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:25:24',
        '2024-05-17 10:25:24'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        187,
        'App\Models\User',
        8,
        'AppName',
        'd03ad75f0c1fe5b90b145c8a8a0dcdc88013c44850d4ac50e8342225ed9aa64a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:25:52',
        '2024-05-17 10:25:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        188,
        'App\Models\User',
        8,
        'AppName',
        '16c79dce22a0d8e79de0ce34351ad4a51ab6cf7fe621a164e8beb4a69089cd46',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 10:26:18',
        '2024-05-17 10:26:18'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        189,
        'App\Models\User',
        8,
        'AppName',
        'bb763494312dde79f6ebfd27d9345b34cdb1efb6577c69f4b6bbc80cb3ef9340',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 17:51:22',
        '2024-05-17 17:51:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        190,
        'App\Models\User',
        8,
        'AppName',
        'e79b5b5a59359ef32c56a903ca670365fc55f902b3d1db4d3c9c2f7d208b1eb4',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 17:52:33',
        '2024-05-17 17:52:33'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        191,
        'App\Models\User',
        8,
        'AppName',
        'e6e2074dedac79a20b625dfeb49c5d814fcb59268f5a62ec0391c1c2740f9a6f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 17:56:39',
        '2024-05-17 17:56:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        192,
        'App\Models\User',
        8,
        'AppName',
        '2b0f2ea036b9f724bf979f75e59a8f48e1d8dc59108b5180f662c3edad0db601',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 17:58:23',
        '2024-05-17 17:58:23'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        193,
        'App\Models\User',
        8,
        'AppName',
        '53b93e8baec863897b366df7359e9faa3ee754f10840c7b52128aee3cdab3088',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:01:21',
        '2024-05-17 18:01:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        194,
        'App\Models\User',
        8,
        'AppName',
        'b4f025f307aa4dca74ff0102c3b0e5e9e257776731a734d30ecf143b97d2da3d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:02:16',
        '2024-05-17 18:02:16'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        195,
        'App\Models\User',
        8,
        'AppName',
        '7149b41189da85b7fd685774129e8fc7dc4b654955fbd74df219d2ac863a337d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:02:27',
        '2024-05-17 18:02:27'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        196,
        'App\Models\User',
        8,
        'AppName',
        '14cbba20d1168e47ec5b70916b21233b323cd01b6adb665d0ebb007f782bc4bc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:02:39',
        '2024-05-17 18:02:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        197,
        'App\Models\User',
        8,
        'AppName',
        '396c03242044fd32fa806a6eddfdea3a58fa772b65bc68e67817bd4534230c51',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:04:43',
        '2024-05-17 18:04:43'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        198,
        'App\Models\User',
        8,
        'AppName',
        '2bce413e33a875f391a6981ba81c979dd92ecfe7c28bbb9ee88033233b4cdcd2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:05:50',
        '2024-05-17 18:05:50'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        199,
        'App\Models\User',
        8,
        'AppName',
        '875a0a8d5adf46c5ed426fe50dde17f0e9d4a8a1ff87e37867e6cc591165ca73',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:06:08',
        '2024-05-17 18:06:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        200,
        'App\Models\User',
        8,
        'AppName',
        'ef12a60ff7e85c00e1880ce8445718f61a33b84ee21d7b63f5e5706cc65b3654',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:07:35',
        '2024-05-17 18:07:35'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        201,
        'App\Models\User',
        8,
        'AppName',
        '384955301fcb976994ebf7c6ef7e30f74def4656efe83a6c9274935b71162b63',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:08:02',
        '2024-05-17 18:08:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        202,
        'App\Models\User',
        8,
        'AppName',
        '8b77cf758bb1d4de4525668c0490bf7fdc67bcccd4a5538d9c9efaec7934e5e7',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:08:18',
        '2024-05-17 18:08:18'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        203,
        'App\Models\User',
        8,
        'AppName',
        '452611992f940da6987d0ebeaadc0c3fb9ec1f659c461c6b019e6bf347f7b9e1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:09:02',
        '2024-05-17 18:09:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        204,
        'App\Models\User',
        8,
        'AppName',
        '81c2188dcce8be0f452cbde259d565af62375de83d10791ef401bc85e41fa733',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:09:56',
        '2024-05-17 18:09:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        205,
        'App\Models\User',
        8,
        'AppName',
        'e1ceb74ade7c4d222fd5d8838fbb55d686b4cf20afa35080fd80da80934c3c07',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:12:40',
        '2024-05-17 18:12:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        206,
        'App\Models\User',
        8,
        'AppName',
        '0cabc4da78b583ac6b6e1caf1883228a45485128948f8d1c96ea899106770e3f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:13:29',
        '2024-05-17 18:13:29'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        207,
        'App\Models\User',
        8,
        'AppName',
        '83b2eef8239ae93b8019d8747fd812b0851e07db03de6d5e0d1c35877e3eadea',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:14:32',
        '2024-05-17 18:14:32'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        208,
        'App\Models\User',
        8,
        'AppName',
        'c627da7a3eecaf6d01ad200216964fcfff990ff694610e81b9a7aca604312675',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:14:51',
        '2024-05-17 18:14:51'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        209,
        'App\Models\User',
        8,
        'AppName',
        '2b03f962b1699d69fe0dc5f024fab1c3b1891943047c873d008ba7826b520443',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:15:13',
        '2024-05-17 18:15:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        210,
        'App\Models\User',
        8,
        'AppName',
        '7daded1c415dd42647c5acbc48f97175452e946c8124c52240643f327f709213',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:15:29',
        '2024-05-17 18:15:29'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        211,
        'App\Models\User',
        8,
        'AppName',
        '54b48b1d73187f5483fdc0b37a77528f603f3795cf4432ac2d00480ed110b36b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:18:43',
        '2024-05-17 18:18:43'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        212,
        'App\Models\User',
        8,
        'AppName',
        '38871c5395907ab7d1266bdeaca27702c0a36745a07ca07a85aa517c8172a170',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:20:39',
        '2024-05-17 18:20:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        213,
        'App\Models\User',
        8,
        'AppName',
        '28dbe146b0bd5e872372cd1bf3576e1e88a6aa18bd7004545dc187492ffa1b11',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:21:56',
        '2024-05-17 18:21:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        214,
        'App\Models\User',
        8,
        'AppName',
        '395e7648829ec604565cd2a415c61ac9900bbf4304ab6bc351e222b24c7ca359',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:29:40',
        '2024-05-17 18:29:40'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        215,
        'App\Models\User',
        8,
        'AppName',
        'ec5b8db08a7a28ddfc3028a6b59d80c7db88efaef6fd570cb52ccd578af650ac',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:30:20',
        '2024-05-17 18:30:20'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        216,
        'App\Models\User',
        8,
        'AppName',
        '2057b67be8630186eb1bfaa95809b3677ec1f41bfe5386adf57f8965e5841920',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:31:22',
        '2024-05-17 18:31:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        217,
        'App\Models\User',
        8,
        'AppName',
        '8f6df06589583b9ad6cb9dd1713a07ffc0f5d3923a0e215300b41470c7068c8d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:31:38',
        '2024-05-17 18:31:38'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        218,
        'App\Models\User',
        8,
        'AppName',
        '6eadb9fe150f3f86787c702b38d7e4b8e4b4ffed8135bc58fca6f141d9bf28c0',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:33:10',
        '2024-05-17 18:33:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        219,
        'App\Models\User',
        8,
        'AppName',
        '8e147115841e876ed94ce073385da2fd9751feab1693ce7a1f3ee8cf76152281',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:35:34',
        '2024-05-17 18:35:34'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        220,
        'App\Models\User',
        8,
        'AppName',
        '9a8986072c36c5fc05ef701708ceb683982bf6c1362d0c3b16137814496d2bbb',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:35:54',
        '2024-05-17 18:35:54'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        221,
        'App\Models\User',
        8,
        'AppName',
        '9c05c54447d4f9cc353df88caea09bcf59f080347bb88a89e05a47a089f2664e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:37:32',
        '2024-05-17 18:37:32'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        222,
        'App\Models\User',
        8,
        'AppName',
        '094a9cd63dd63cc851ebe69b41453675a201b2d7e86e91a2b5d07d8d0b03ef50',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:37:45',
        '2024-05-17 18:37:45'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        223,
        'App\Models\User',
        8,
        'AppName',
        '14a1f35389c3b8a2402ec209821ec0575deb62cf468aa880d0c1067b0e589cfe',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:39:25',
        '2024-05-17 18:39:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        224,
        'App\Models\User',
        8,
        'AppName',
        'f2d406b141bcf5437038e4db5478cbe016b0252bdd21932b0293c335eefbe498',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:40:35',
        '2024-05-17 18:40:35'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        225,
        'App\Models\User',
        8,
        'AppName',
        'ec8419282129dbbd3e153d6301cda3ad241b1880d2570ff72c905ef32a3151a5',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:47:32',
        '2024-05-17 18:47:32'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        226,
        'App\Models\User',
        8,
        'AppName',
        'de69edb26002fb1e6e73fed996455224b680cb6add73c087a61ad2c8a2f809f5',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:48:16',
        '2024-05-17 18:48:16'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        227,
        'App\Models\User',
        8,
        'AppName',
        '0929522e1f33bd3c6c384bd8c52de5f89d85cc358a78d552bae032fda85864b1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:49:01',
        '2024-05-17 18:49:01'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        228,
        'App\Models\User',
        8,
        'AppName',
        '65dd3b81356acd331a9da1a76db61606e6225b76c658cd8f6a2b9146dfdfb7c8',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:49:32',
        '2024-05-17 18:49:32'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        229,
        'App\Models\User',
        8,
        'AppName',
        'fba885b7bf88d502ca44332e1cd17134e760ceaa64487b15e60c147f417d9a22',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:50:34',
        '2024-05-17 18:50:34'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        230,
        'App\Models\User',
        8,
        'AppName',
        '952fb158191756ff686d8cab10650c88ff1a1bad6481def85cffda0722ef5e62',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:53:02',
        '2024-05-17 18:53:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        231,
        'App\Models\User',
        8,
        'AppName',
        '77e309dfae85a9e9ec82224eb42f24361f055e8ec1df8d133d0c4c5e698de2bd',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:55:52',
        '2024-05-17 18:55:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        232,
        'App\Models\User',
        8,
        'AppName',
        '3511c9338bdb9f1c7795491569280d46db7b94eb8ddfa5e66d11a0857f2978a2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 18:56:21',
        '2024-05-17 18:56:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        233,
        'App\Models\User',
        8,
        'AppName',
        '92b54ab6f0b506a2d48f4850f88c36518cc31d0b1ee900b86e06bbe69465a7ab',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 19:02:44',
        '2024-05-17 19:02:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        234,
        'App\Models\User',
        8,
        'AppName',
        '17e860c4b57aaa3437849e9c20a5f5137d9c0540fdef3d5345bac842143d26e1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 19:05:21',
        '2024-05-17 19:05:21'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        235,
        'App\Models\User',
        8,
        'AppName',
        'f4ab227adc1fa76b6409cbc34f9674065b1f25f99686e1e54617c3e68b0def0a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 19:09:48',
        '2024-05-17 19:09:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        236,
        'App\Models\User',
        8,
        'AppName',
        '6ff6674ec1c150ab904a3102982df32a2bb6e3a851b333f8816e83a033ef4272',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 19:11:45',
        '2024-05-17 19:11:45'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        237,
        'App\Models\User',
        8,
        'AppName',
        '88aae1eca2d6b4e317ae668b7d5eda23f353f98644c17e564070d4b80e8443dc',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 19:15:47',
        '2024-05-17 19:15:47'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        238,
        'App\Models\User',
        8,
        'AppName',
        'deb42679661ae8142551570dced78f56f7a6e7d937f90f92762d615dbaed333d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-17 22:13:53',
        '2024-05-17 22:13:53'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        239,
        'App\Models\User',
        8,
        'AppName',
        '4d7a0dcc4c7a8c63b46e822f7347e4c3ddacefbe835851aac42eca0f8959c79f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-20 22:40:10',
        '2024-05-20 22:40:10'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        240,
        'App\Models\User',
        8,
        'AppName',
        '4937c4cfad904668f389e6b8983bd8c36d69a92b56c5b9d9ea557002e65c223b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 01:20:17',
        '2024-05-21 01:20:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        241,
        'App\Models\User',
        8,
        'AppName',
        '85fa2af98dd265cb78a8271e9e2e533cfd1cd94521984fdaedbea00a8ef8dda5',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 09:34:03',
        '2024-05-21 09:34:03'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        242,
        'App\Models\User',
        8,
        'AppName',
        'a980507087d4e3fba8be0d2418932a8c8593239ae38def743a5f20b10ae0794e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 12:04:17',
        '2024-05-21 12:04:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        243,
        'App\Models\User',
        8,
        'AppName',
        '2abe93a07b6c85d230b16eb7b10538a6d8ac0907c54de9b458c19f9bfb804233',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 21:42:08',
        '2024-05-21 21:42:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        244,
        'App\Models\User',
        8,
        'AppName',
        '5ca4e6f5fc46b5929deeb58ceaacb03935f4daaab0968ba20c879cb4cfcd7b59',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 21:59:19',
        '2024-05-21 21:59:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        245,
        'App\Models\User',
        8,
        'AppName',
        '248031b9b40aaf9af058e214b7f5a3e4d7b963ee156de900fc0e999cc9219297',
        '["*"]',
        NULL,
        NULL,
        '2024-05-21 22:04:06',
        '2024-05-21 22:04:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        246,
        'App\Models\User',
        8,
        'AppName',
        '697fab8943fd06edd8deac2b525fa1e353e16a3170a3856d832cf6ea642da9d3',
        '["*"]',
        NULL,
        NULL,
        '2024-05-22 11:10:58',
        '2024-05-22 11:10:58'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        247,
        'App\Models\User',
        1,
        'AppName',
        '84034e229e2cd07d8c05df188e8d339abff15597f81b8b3a9db33b70b4b44ce6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-22 11:14:39',
        '2024-05-22 11:14:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        248,
        'App\Models\User',
        8,
        'AppName',
        '8c4dd53f12d05064d9e23ac56bcac6c097f0bc2e04410051fc0491e8fb72291a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-22 11:55:12',
        '2024-05-22 11:55:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        249,
        'App\Models\User',
        8,
        'AppName',
        '69fe891859cb8366c79127621f99f89b30d1a1a66157204b095674c17c69b1e9',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 12:28:46',
        '2024-05-23 12:28:46'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        250,
        'App\Models\User',
        3,
        'AppName',
        '2d450c6796ccf006785e1b4f105a3bcb9d84f2820f010616d17dc429f0ce551c',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 12:29:38',
        '2024-05-23 12:29:38'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        251,
        'App\Models\User',
        8,
        'AppName',
        '54aa84ba7f307879a4c92276aead2cd6f6a154b4029782ec248748ffa3b9b182',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 12:36:18',
        '2024-05-23 12:36:18'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        252,
        'App\Models\User',
        7,
        'AppName',
        'c2fc5bd81b6b3dbe72c010390e4a383675f814caf4d46e18035b38cc1aafb50b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 12:41:15',
        '2024-05-23 12:41:15'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        253,
        'App\Models\User',
        8,
        'AppName',
        '04343d1fa48a44f8fb4a9c87d0a9598f828a91b9d3cc5dc999d019e009aa1af7',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:18:42',
        '2024-05-23 23:18:42'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        254,
        'App\Models\User',
        2,
        'AppName',
        '9c967b4169f80bbf06607bb5575c82e40203d15f4c49e497756135d953696af2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:19:17',
        '2024-05-23 23:19:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        255,
        'App\Models\User',
        8,
        'AppName',
        '7e91c64f828b2f5dd483ea4559d30476061dc39cf025636c84edfe45d2c50893',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:24:12',
        '2024-05-23 23:24:12'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        256,
        'App\Models\User',
        7,
        'AppName',
        '91ae0f059f9b4a88a74924410d10b9945b961351d97bd9e680d17591fa84bcb6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:26:11',
        '2024-05-23 23:26:11'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        257,
        'App\Models\User',
        7,
        'AppName',
        '8356ee3c8f58b188c0861f4709f96b54810a2646afd565e1f98b168284baf4eb',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:26:54',
        '2024-05-23 23:26:54'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        258,
        'App\Models\User',
        8,
        'AppName',
        '97da34f0f8422bb00fce0970caad857fbc01661f89086bf80af6d4cd7bfb3971',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:27:52',
        '2024-05-23 23:27:52'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        259,
        'App\Models\User',
        7,
        'AppName',
        '40de6f064c6f1dd00ad600fa4af4f2ee96f9e168c79baef3e25ef47011695cd4',
        '["*"]',
        NULL,
        NULL,
        '2024-05-23 23:34:13',
        '2024-05-23 23:34:13'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        260,
        'App\Models\User',
        1,
        'AppName',
        '4552999e4e33183f098fa4c6ee0a84dc6c64f7b5d6025ce3712344b265adeec6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 12:29:25',
        '2024-05-24 12:29:25'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        261,
        'App\Models\User',
        1,
        'AppName',
        '763c368c6a9c49dcd55c6d3557e87d44bf4874226967934614096da4ed1d439c',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 12:29:39',
        '2024-05-24 12:29:39'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        262,
        'App\Models\User',
        8,
        'AppName',
        'c240946a7d994d4c6029ec3e1ededb84dc9695356e5c04589d3f96f4d154d669',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 12:41:27',
        '2024-05-24 12:41:27'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        263,
        'App\Models\User',
        7,
        'AppName',
        '68c8d167440c8e054eb8272582b174e78422a98f701978b8947e0b798a40348c',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 13:26:56',
        '2024-05-24 13:26:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        264,
        'App\Models\User',
        8,
        'AppName',
        '04d3448777628b0cc05361d96a160b4ee66884eaece481d4a3395c35125df93f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:13:04',
        '2024-05-24 22:13:04'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        265,
        'App\Models\User',
        8,
        'AppName',
        'eb1c3a107b22ecf9b75357b02dafe031d7210e81cf583f08224719950d4b5d9d',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:16:08',
        '2024-05-24 22:16:08'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        266,
        'App\Models\User',
        8,
        'AppName',
        'd1098b2f446cb8042f2bcb228a21b1507d20d8c1965e04fcf69937451853ab9f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:22:17',
        '2024-05-24 22:22:17'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        267,
        'App\Models\User',
        8,
        'AppName',
        '8dd553cd734d0c499f807e96b3dc4d6343c145038e67a5225cfedd7221f83d59',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:30:20',
        '2024-05-24 22:30:20'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        268,
        'App\Models\User',
        8,
        'AppName',
        '0ef57e0fcc885b8d08efd6cacccd0a5ec249ce3d1804a58e6b2c735ecbaa418a',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:32:41',
        '2024-05-24 22:32:41'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        269,
        'App\Models\User',
        8,
        'AppName',
        '66500522a88d00693f9224dd8c660a0b8d78487590759013d50a8c206497fcdf',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:33:02',
        '2024-05-24 22:33:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        270,
        'App\Models\User',
        8,
        'AppName',
        '2606f9e41a7e8d60de8ec43239799312aa3b282d9ddd307865137082ed7cf4f7',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 22:46:29',
        '2024-05-24 22:46:29'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        271,
        'App\Models\User',
        8,
        'AppName',
        '0669dee1a2f9b143177e674db9c55c430f7509f13a19b0d880ad8ba043241229',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:12:48',
        '2024-05-24 23:12:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        272,
        'App\Models\User',
        8,
        'AppName',
        '99833491061b3a80ea42a5e1c1e29c53707323a8e6dd9daf7441ce953b6f6cba',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:13:02',
        '2024-05-24 23:13:02'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        273,
        'App\Models\User',
        8,
        'AppName',
        '31effb2aa0ebcdc3b54d63f9aa97e9b0d517fa8fc53dd76cec146a9812ee7b84',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:13:37',
        '2024-05-24 23:13:37'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        274,
        'App\Models\User',
        8,
        'AppName',
        '9ab933ccc3c7a3f807160717051618a427ce1cd3ba3808669ab4541504849394',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:28:23',
        '2024-05-24 23:28:23'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        275,
        'App\Models\User',
        8,
        'AppName',
        '83a1c78d93677bbab849dfd081f7bc859c59ae0adb1f40b29169b0ffc4d93358',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:29:14',
        '2024-05-24 23:29:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        276,
        'App\Models\User',
        8,
        'AppName',
        'd9941fffca03173ab609e55b3b5036b9be30e13737f73ba32c7d7e63fc8c0fc0',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:29:57',
        '2024-05-24 23:29:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        277,
        'App\Models\User',
        8,
        'AppName',
        'bbf006a08fe8c4112c07e8dfc1c779efb06600e6540b2b707acab623ea106dc7',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:30:26',
        '2024-05-24 23:30:26'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        278,
        'App\Models\User',
        8,
        'AppName',
        'c162e558e18c410e369290edcf45f5762f91412d90ae9f7fc4d81363e27278c3',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:38:56',
        '2024-05-24 23:38:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        279,
        'App\Models\User',
        8,
        'AppName',
        '4e11d2b1af253e4873ad1e8f1d1172b30aa1a24cff19064f70129e60b5fb7ea1',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:49:18',
        '2024-05-24 23:49:18'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        280,
        'App\Models\User',
        8,
        'AppName',
        'c56656528511c01639ef3df206633a881a0df109fdcf5de6bc6f46a33c3ae19f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-24 23:55:49',
        '2024-05-24 23:55:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        281,
        'App\Models\User',
        8,
        'AppName',
        '1c0c5dbd41d3aa2658cfe0b75b5f29196cf53d9eb37d26b6921f73b0ca954b60',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:07:56',
        '2024-05-25 00:07:56'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        282,
        'App\Models\User',
        8,
        'AppName',
        'fe81c5dc5bebab6cc7dd093606fbb6b6aa79a2b017dd466888419576c590007b',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:16:09',
        '2024-05-25 00:16:09'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        283,
        'App\Models\User',
        8,
        'AppName',
        '4cb42a41609754b1d55a2dea8c42ab34cbb56ba304e04b36eab4e9685bd3377e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:18:06',
        '2024-05-25 00:18:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        284,
        'App\Models\User',
        8,
        'AppName',
        '084852db5401679926477095a9bf3e21ab4480cfa41a2c3539be0ee3488250e3',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:21:51',
        '2024-05-25 00:21:51'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        285,
        'App\Models\User',
        8,
        'AppName',
        'e6a0e599c92e95c4c749a913b797e33b4a86bec4a651a2ff3e2919e6b3c5eaca',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:25:44',
        '2024-05-25 00:25:44'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        286,
        'App\Models\User',
        8,
        'AppName',
        'c69ede85edae40be88937bafcaccdaec5daed03d4a052b9a21dc11fe756d937c',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:31:50',
        '2024-05-25 00:31:50'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        287,
        'App\Models\User',
        8,
        'AppName',
        'd0de5bb8f0aa817f82bac13041de5022d1ccef6c7b5f093697e287eb3aff4d82',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 00:51:06',
        '2024-05-25 00:51:06'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        288,
        'App\Models\User',
        8,
        'AppName',
        '7d110023e74ae8546e7dc434cec52e90239f2ba46b0741127f22a8749e5d2f6e',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 01:12:31',
        '2024-05-25 01:12:31'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        289,
        'App\Models\User',
        8,
        'AppName',
        '8bf61e86b8b2ecbeaed60eceea3326d204cb667e2956cd471a1e88e4b2ef51dd',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 22:33:22',
        '2024-05-25 22:33:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        290,
        'App\Models\User',
        1,
        'AppName',
        '6c066678facaecf9e9dd4b67287c1ecd66a031516603d61fed27e8e1d293a739',
        '["*"]',
        NULL,
        NULL,
        '2024-05-25 23:26:14',
        '2024-05-25 23:26:14'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        291,
        'App\Models\User',
        1,
        'AppName',
        '048fc212618abeb72a4218caad8dcddbc60d061500bb59b8b71d13bd914a1767',
        '["*"]',
        NULL,
        NULL,
        '2024-05-26 00:44:50',
        '2024-05-26 00:44:50'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        292,
        'App\Models\User',
        1,
        'AppName',
        '25a48eedb19987f87d0d0c2ba9b150c66b71d77b0b31035adb26e19a3d96a524',
        '["*"]',
        NULL,
        NULL,
        '2024-05-26 16:35:48',
        '2024-05-26 16:35:48'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        293,
        'App\Models\User',
        8,
        'AppName',
        '2112d0f2a92b5dde5dbc29c827332b81b890ccce8db1b2141d87c31387ee22f6',
        '["*"]',
        NULL,
        NULL,
        '2024-05-26 16:36:00',
        '2024-05-26 16:36:00'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        294,
        'App\Models\User',
        1,
        'AppName',
        '0b0bf75701cebf688625337e0310b8570b4e2e74be61835d854ec47f13ef9441',
        '["*"]',
        NULL,
        NULL,
        '2024-05-27 16:23:35',
        '2024-05-27 16:23:35'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        295,
        'App\Models\User',
        8,
        'AppName',
        '5242d49a6087a682d9f9b1826d92d34b52422ca392e39ef05e59e97169a7362f',
        '["*"]',
        NULL,
        NULL,
        '2024-05-27 20:22:49',
        '2024-05-27 20:22:49'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        296,
        'App\Models\User',
        8,
        'AppName',
        '45ffebc7902401f1614470d00e9d0e068a61f39f58d75e3aeebf840438e759a2',
        '["*"]',
        NULL,
        NULL,
        '2024-05-27 20:24:19',
        '2024-05-27 20:24:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        297,
        'App\Models\User',
        7,
        'AppName',
        '59b30580d329d57392aee26cf548afc0bef4526cd67953c6612b10a8a4396c48',
        '["*"]',
        NULL,
        NULL,
        '2024-05-27 21:11:19',
        '2024-05-27 21:11:19'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        298,
        'App\Models\User',
        2,
        'AppName',
        'fc554add48dbf662cee53e70a7fbf6bcdf046bf6a7a2ab4d1275b2c61e961dcd',
        '["*"]',
        NULL,
        NULL,
        '2024-05-27 21:11:36',
        '2024-05-27 21:11:36'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        299,
        'App\Models\User',
        7,
        'AppName',
        '96e3f0aa2c5fc59e321b2fe119c49e7bf6e428f5b098cd56fb466cd07b18ff13',
        '["*"]',
        NULL,
        NULL,
        '2024-06-01 18:49:57',
        '2024-06-01 18:49:57'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        300,
        'App\Models\User',
        2,
        'AppName',
        'ea9cbf56b3b37d0d86b8ff7a2df731a508eb1150ef867207b8085de112dfe77b',
        '["*"]',
        NULL,
        NULL,
        '2024-06-01 18:52:45',
        '2024-06-01 18:52:45'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        301,
        'App\Models\User',
        8,
        'AppName',
        '43ebfab0744984e984079f162d0e990c61b3da5a7ff1a58e8da5f270de123e2f',
        '["*"]',
        NULL,
        NULL,
        '2024-06-01 21:48:00',
        '2024-06-01 21:48:00'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        302,
        'App\Models\User',
        8,
        'AppName',
        '2fa6edfe1b355f1e74fad6a51bb70978697e1732dd7dc4d6781315089dbb7c9f',
        '["*"]',
        NULL,
        NULL,
        '2024-06-02 12:32:03',
        '2024-06-02 12:32:03'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        303,
        'App\Models\User',
        8,
        'AppName',
        '167ba8fad47ded9413d0e3950c39516268c5341943d69568fbf9c6122f2c2298',
        '["*"]',
        NULL,
        NULL,
        '2024-06-02 12:54:26',
        '2024-06-02 12:54:26'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        304,
        'App\Models\User',
        1,
        'AppName',
        '2903a02ac2bbbf6e019ce1590db6be118a601840561cb8806b43854419e536e8',
        '["*"]',
        NULL,
        NULL,
        '2024-06-02 13:25:35',
        '2024-06-02 13:25:35'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        305,
        'App\Models\User',
        8,
        'AppName',
        'dc39e98417f0b94bf79e07d2e85a92717069c389b2bc19728a4dcb34eabd6d95',
        '["*"]',
        NULL,
        NULL,
        '2024-06-02 13:30:22',
        '2024-06-02 13:30:22'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        306,
        'App\Models\User',
        8,
        'AppName',
        '4455b2584e35aa7eef21a746a4ec428827221f621e23e2e7a26cb1fddb801a09',
        '["*"]',
        NULL,
        NULL,
        '2024-06-02 22:16:36',
        '2024-06-02 22:16:36'
    );

INSERT INTO
    public.personal_access_tokens
VALUES (
        307,
        'App\Models\User',
        8,
        'AppName',
        '0cfc010ac1d7674adc0d89460ef76a6bfda82a9201caf7bf9f2421f650fab2cb',
        '["*"]',
        NULL,
        NULL,
        '2024-06-03 12:51:09',
        '2024-06-03 12:51:09'
    );

--
-- TOC entry 3501 (class 0 OID 16444)
-- Dependencies: 226
-- Data for Name: protocols; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3503 (class 0 OID 16450)
-- Dependencies: 228
-- Data for Name: subject_areas; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.subject_areas
VALUES (
        1,
        'Инженерные науки',
        NULL,
        NULL
    );

INSERT INTO
    public.subject_areas
VALUES (
        2,
        'Информационные технологии',
        NULL,
        NULL
    );

INSERT INTO
    public.subject_areas
VALUES (
        3,
        'Естественные науки',
        NULL,
        NULL
    );

INSERT INTO
    public.subject_areas
VALUES (
        4,
        'Науки об обществе',
        NULL,
        NULL
    );

INSERT INTO
    public.subject_areas
VALUES (
        5,
        'Экология и природопользование',
        NULL,
        NULL
    );

INSERT INTO
    public.subject_areas
VALUES (
        6,
        'Архитектура и искусство',
        NULL,
        NULL
    );

--
-- TOC entry 3505 (class 0 OID 16454)
-- Dependencies: 230
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO
    public.users
VALUES (
        2,
        'Иванов Иван Иванович',
        'Эксперт',
        'IIIvanov',
        '$2y$12$2tKTuy8/WTWScSUsRwjB1e7DZXLl.e3mo2sBHR0qcU1DH0PxN8uhC',
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    public.users
VALUES (
        3,
        'Петров Петр Петрович',
        'Автор',
        'PPPetrov',
        '$2y$12$GDGtFI5oNIGRCgA1.4JLWe1CDchTIC103vFcNEjKJejwvdV6cpVni',
        NULL,
        '2024-01-14 00:18:38',
        '2024-01-14 00:18:38'
    );

INSERT INTO
    public.users
VALUES (
        8,
        'Воронцова Наталья Викторовна',
        'Секретарь',
        'VNV',
        '$2y$12$/ANosxX6yl2vBfjaQH.c5erlWZ2DwNOkG9gh9KN.K7dXb0jNfhW6u',
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    public.users
VALUES (
        7,
        'Лобацкая Раиса Моисеевна',
        'Председатель',
        'LobRM',
        '$2y$12$zB7/gURmzTb4EVLHwErKKuI43yCxLkZYRCvHWAw9xA7lskZ8w9vgy',
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    public.users
VALUES (
        1,
        'admin',
        'Администратор',
        'admin',
        '$2y$12$il8sdUz7b/eSjXzR8FSo.u5/nzTvmXoCmigU36EPDEGbVu5yKd8xC',
        NULL,
        NULL,
        NULL
    );

--
-- TOC entry 3507 (class 0 OID 16460)
-- Dependencies: 232
-- Data for Name: users_subject_areas; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users_subject_areas VALUES (7, 1, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (7, 6, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (7, 2, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (7, 3, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (7, 4, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (7, 5, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (8, 6, NULL, NULL);

INSERT INTO public.users_subject_areas VALUES (2, 3, NULL, NULL);

--
-- TOC entry 3508 (class 0 OID 16463)
-- Dependencies: 233
-- Data for Name: works; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3510 (class 0 OID 16469)
-- Dependencies: 235
-- Data for Name: works_subject_areas; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- TOC entry 3527 (class 0 OID 0)
-- Dependencies: 212
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval ( 'public.failed_jobs_id_seq', 1, false );

--
-- TOC entry 3528 (class 0 OID 0)
-- Dependencies: 214
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval ( 'public.migrations_id_seq', 22, true );

--
-- TOC entry 3529 (class 0 OID 0)
-- Dependencies: 218
-- Name: oauth_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval ( 'public.oauth_clients_id_seq', 2, true );

--
-- TOC entry 3530 (class 0 OID 0)
-- Dependencies: 220
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval (
        'public.oauth_personal_access_clients_id_seq', 1, true
    );

--
-- TOC entry 3531 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval (
        'public.personal_access_tokens_id_seq', 307, true
    );

--
-- TOC entry 3532 (class 0 OID 0)
-- Dependencies: 227
-- Name: protocols_id_protocol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval (
        'public.protocols_id_protocol_seq', 27, true
    );

--
-- TOC entry 3533 (class 0 OID 0)
-- Dependencies: 229
-- Name: subject_areas_id_subject_area_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval (
        'public.subject_areas_id_subject_area_seq', 7, true
    );

--
-- TOC entry 3534 (class 0 OID 0)
-- Dependencies: 231
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval ( 'public.users_id_user_seq', 8, true );

--
-- TOC entry 3535 (class 0 OID 0)
-- Dependencies: 234
-- Name: works_id_work_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval ( 'public.works_id_work_seq', 95, true );

--
-- TOC entry 3281 (class 2606 OID 16482)
-- Name: autors_works autors_works_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.autors_works
ADD CONSTRAINT autors_works_pkey PRIMARY KEY (id_user, id_work);

--
-- TOC entry 3283 (class 2606 OID 16484)
-- Name: experts_works experts_works_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.experts_works
ADD CONSTRAINT experts_works_pkey PRIMARY KEY (id_user, id_work);

--
-- TOC entry 3285 (class 2606 OID 16486)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);

--
-- TOC entry 3287 (class 2606 OID 16488)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);

--
-- TOC entry 3289 (class 2606 OID 16490)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);

--
-- TOC entry 3291 (class 2606 OID 16492)
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_access_tokens
ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);

--
-- TOC entry 3294 (class 2606 OID 16494)
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_auth_codes
ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);

--
-- TOC entry 3297 (class 2606 OID 16496)
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_clients
ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);

--
-- TOC entry 3300 (class 2606 OID 16498)
-- Name: oauth_personal_access_clients oauth_personal_access_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_personal_access_clients
ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);

--
-- TOC entry 3303 (class 2606 OID 16500)
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_refresh_tokens
ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);

--
-- TOC entry 3305 (class 2606 OID 16502)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);

--
-- TOC entry 3307 (class 2606 OID 16504)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);

--
-- TOC entry 3309 (class 2606 OID 16506)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);

--
-- TOC entry 3312 (class 2606 OID 16508)
-- Name: protocols protocols_date_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.protocols
ADD CONSTRAINT protocols_date_unique UNIQUE (meeting_date);

--
-- TOC entry 3314 (class 2606 OID 16510)
-- Name: protocols protocols_link_protocol_file_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.protocols
ADD CONSTRAINT protocols_link_protocol_file_unique UNIQUE (link_protocol_file);

--
-- TOC entry 3316 (class 2606 OID 16512)
-- Name: protocols protocols_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.protocols
ADD CONSTRAINT protocols_pkey PRIMARY KEY (id_protocol);

--
-- TOC entry 3318 (class 2606 OID 16514)
-- Name: subject_areas subject_areas_name_subject_area_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject_areas
ADD CONSTRAINT subject_areas_name_subject_area_unique UNIQUE (name_subject_area);

--
-- TOC entry 3320 (class 2606 OID 16516)
-- Name: subject_areas subject_areas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject_areas
ADD CONSTRAINT subject_areas_pkey PRIMARY KEY (id_subject_area);

--
-- TOC entry 3322 (class 2606 OID 16518)
-- Name: users users_login_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
ADD CONSTRAINT users_login_unique UNIQUE (login);

--
-- TOC entry 3324 (class 2606 OID 16520)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
ADD CONSTRAINT users_pkey PRIMARY KEY (id_user);

--
-- TOC entry 3326 (class 2606 OID 16522)
-- Name: users_subject_areas users_subject_areas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_subject_areas
ADD CONSTRAINT users_subject_areas_pkey PRIMARY KEY (id_user, id_subject_area);

--
-- TOC entry 3328 (class 2606 OID 16524)
-- Name: works works_link_file_extract_protocol_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works
ADD CONSTRAINT works_link_file_extract_protocol_unique UNIQUE (link_file_extract_protocol);

--
-- TOC entry 3330 (class 2606 OID 16526)
-- Name: works works_link_text_file_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works
ADD CONSTRAINT works_link_text_file_unique UNIQUE (link_text_file);

--
-- TOC entry 3332 (class 2606 OID 16528)
-- Name: works works_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works
ADD CONSTRAINT works_pkey PRIMARY KEY (id_work);

--
-- TOC entry 3334 (class 2606 OID 16530)
-- Name: works_subject_areas works_subject_areas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works_subject_areas
ADD CONSTRAINT works_subject_areas_pkey PRIMARY KEY (id_work, id_subject_area);

--
-- TOC entry 3292 (class 1259 OID 16531)
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);

--
-- TOC entry 3295 (class 1259 OID 16532)
-- Name: oauth_auth_codes_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);

--
-- TOC entry 3298 (class 1259 OID 16533)
-- Name: oauth_clients_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);

--
-- TOC entry 3301 (class 1259 OID 16534)
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);

--
-- TOC entry 3310 (class 1259 OID 16535)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);

--
-- TOC entry 3483 (class 2618 OID 16443)
-- Name: protocol_works _RETURN; Type: RULE; Schema: public; Owner: postgres
--

CREATE OR REPLACE VIEW public.protocol_works AS
 SELECT works.type,
        CASE
            WHEN ((works.type)::text = ANY (ARRAY[('Учебник с грифом'::character varying)::text, ('Учебное пособие с грифом'::character varying)::text])) THEN 'С грифом'::text
            ELSE 'Без грифа'::text
        END AS stamp,
    works.name_work,
    users.full_name AS autor,
    string_agg(DISTINCT (subject_areas.name_subject_area)::text, ', '::text) AS name_subject_area,
    works.final_grade,
    works.pages_number,
    works.publisher,
    works.publishing_year
   FROM (((((public.works
     LEFT JOIN public.works_subject_areas ON ((works.id_work = works_subject_areas.id_work)))
     LEFT JOIN public.subject_areas ON ((works_subject_areas.id_subject_area = subject_areas.id_subject_area)))
     LEFT JOIN public.autors_works ON ((works.id_work = autors_works.id_work)))
     LEFT JOIN public.users ON ((autors_works.id_user = users.id_user)))
     LEFT JOIN public.protocols ON ((works.id_protocol = protocols.id_protocol)))
  WHERE (((works.status)::text = 'Внесена в протокол'::text) AND ((protocols.status)::text = 'Создан'::text))
  GROUP BY works.id_work, users.full_name;

--
-- TOC entry 3484 (class 2618 OID 16588)
-- Name: all_works _RETURN; Type: RULE; Schema: public; Owner: postgres
--

CREATE OR REPLACE VIEW public.all_works AS
 SELECT works.id_work,
    works.name_work,
    string_agg(DISTINCT (subject_areas.name_subject_area)::text, ', '::text) AS name_subject_area,
    works.original_percent,
    works.created_at,
    works.final_grade,
    works.status,
    works.id_protocol,
    regexp_replace((works.link_pdf_file)::text, '^.*/'::text, ''::text) AS file_name,
    string_agg(DISTINCT concat(split_part((users.full_name)::text, ' '::text, 1), ' ',
        CASE
            WHEN (array_length(string_to_array((users.full_name)::text, ' '::text), 1) > 2) THEN ("left"(split_part((users.full_name)::text, ' '::text, 2), 1) || '.'::text)
            ELSE ''::text
        END,
        CASE
            WHEN (array_length(string_to_array((users.full_name)::text, ' '::text), 1) > 1) THEN ("left"(split_part((users.full_name)::text, ' '::text, 3), 1) || '.'::text)
            ELSE ''::text
        END), ', '::text) AS experts,
    regexp_replace((works.link_text_percent1)::text, '^.*/'::text, ''::text) AS file_text_percent1,
    regexp_replace((works.link_text_percent2)::text, '^.*/'::text, ''::text) AS file_text_percent2,
    regexp_replace((works.link_text_percent3)::text, '^.*/'::text, ''::text) AS file_text_percent3,
    regexp_replace((works.link_text_percent4)::text, '^.*/'::text, ''::text) AS file_text_percent4,
    regexp_replace((works.link_text_percent5)::text, '^.*/'::text, ''::text) AS file_text_percent5,
    works.percent1,
    works.percent2,
    works.percent3,
    works.percent4,
    works.percent5
   FROM (((((public.works
     LEFT JOIN public.works_subject_areas ON ((works.id_work = works_subject_areas.id_work)))
     LEFT JOIN public.subject_areas ON ((works_subject_areas.id_subject_area = subject_areas.id_subject_area)))
     LEFT JOIN public.users_subject_areas ON ((subject_areas.id_subject_area = users_subject_areas.id_subject_area)))
     LEFT JOIN public.users ON ((users_subject_areas.id_user = users.id_user)))
     LEFT JOIN public.autors_works ON ((works.id_work = autors_works.id_work)))
  WHERE ((users.id_user <> autors_works.id_user) AND ((users.role)::text <> 'Автор'::text) AND ((users.role)::text <> 'Администратор'::text))
  GROUP BY works.id_work;

--
-- TOC entry 3335 (class 2606 OID 16538)
-- Name: autors_works autors_works_id_user_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.autors_works
ADD CONSTRAINT autors_works_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users (id_user) ON DELETE CASCADE;

--
-- TOC entry 3336 (class 2606 OID 16543)
-- Name: autors_works autors_works_id_work_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.autors_works
ADD CONSTRAINT autors_works_id_work_foreign FOREIGN KEY (id_work) REFERENCES public.works (id_work) ON DELETE CASCADE;

--
-- TOC entry 3337 (class 2606 OID 16548)
-- Name: experts_works experts_works_id_user_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.experts_works
ADD CONSTRAINT experts_works_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users (id_user) ON DELETE CASCADE;

--
-- TOC entry 3338 (class 2606 OID 16553)
-- Name: experts_works experts_works_id_work_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.experts_works
ADD CONSTRAINT experts_works_id_work_foreign FOREIGN KEY (id_work) REFERENCES public.works (id_work) ON DELETE CASCADE;

--
-- TOC entry 3339 (class 2606 OID 16558)
-- Name: users_subject_areas users_subject_areas_id_subject_area_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_subject_areas
ADD CONSTRAINT users_subject_areas_id_subject_area_foreign FOREIGN KEY (id_subject_area) REFERENCES public.subject_areas (id_subject_area) ON DELETE CASCADE;

--
-- TOC entry 3340 (class 2606 OID 16563)
-- Name: users_subject_areas users_subject_areas_id_user_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_subject_areas
ADD CONSTRAINT users_subject_areas_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users (id_user) ON DELETE CASCADE;

--
-- TOC entry 3341 (class 2606 OID 16568)
-- Name: works works_id_protocol_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works
ADD CONSTRAINT works_id_protocol_foreign FOREIGN KEY (id_protocol) REFERENCES public.protocols (id_protocol) ON DELETE CASCADE;

--
-- TOC entry 3342 (class 2606 OID 16573)
-- Name: works_subject_areas works_subject_areas_id_subject_area_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works_subject_areas
ADD CONSTRAINT works_subject_areas_id_subject_area_foreign FOREIGN KEY (id_subject_area) REFERENCES public.subject_areas (id_subject_area) ON DELETE CASCADE;

--
-- TOC entry 3343 (class 2606 OID 16578)
-- Name: works_subject_areas works_subject_areas_id_work_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.works_subject_areas
ADD CONSTRAINT works_subject_areas_id_work_foreign FOREIGN KEY (id_work) REFERENCES public.works (id_work) ON DELETE CASCADE;

-- Completed on 2024-06-03 13:10:12

--
-- PostgreSQL database dump complete
--