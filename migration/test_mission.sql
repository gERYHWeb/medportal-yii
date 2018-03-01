--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.4
-- Dumped by pg_dump version 9.4.4
-- Started on 2018-03-01 08:01:28

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 176 (class 3079 OID 11855)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2017 (class 0 OID 0)
-- Dependencies: 176
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 175 (class 1259 OID 24613)
-- Name: consts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE consts (
    const_id integer NOT NULL,
    language_id integer DEFAULT 1 NOT NULL,
    value character varying(255) NOT NULL,
    type character(100)
);


ALTER TABLE consts OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 24611)
-- Name: consts_const_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE consts_const_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consts_const_id_seq OWNER TO postgres;

--
-- TOC entry 2018 (class 0 OID 0)
-- Dependencies: 174
-- Name: consts_const_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE consts_const_id_seq OWNED BY consts.const_id;


--
-- TOC entry 173 (class 1259 OID 24601)
-- Name: orders; Type: TABLE; Schema: public; Owner: ubuntu; Tablespace: 
--

CREATE TABLE orders (
    order_id integer NOT NULL,
    first_name character varying(150) NOT NULL,
    last_name character varying(150) NOT NULL,
    patronymic character varying(150) NOT NULL,
    email character varying(150) NOT NULL,
    specialization integer NOT NULL,
    description text NOT NULL,
    status integer DEFAULT 0 NOT NULL,
    date date DEFAULT now(),
    degree integer
);


ALTER TABLE orders OWNER TO ubuntu;

--
-- TOC entry 172 (class 1259 OID 24599)
-- Name: orders_order_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE orders_order_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE orders_order_id_seq OWNER TO ubuntu;

--
-- TOC entry 2019 (class 0 OID 0)
-- Dependencies: 172
-- Name: orders_order_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ubuntu
--

ALTER SEQUENCE orders_order_id_seq OWNED BY orders.order_id;


--
-- TOC entry 1891 (class 2604 OID 24616)
-- Name: const_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY consts ALTER COLUMN const_id SET DEFAULT nextval('consts_const_id_seq'::regclass);


--
-- TOC entry 1888 (class 2604 OID 24604)
-- Name: order_id; Type: DEFAULT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY orders ALTER COLUMN order_id SET DEFAULT nextval('orders_order_id_seq'::regclass);


--
-- TOC entry 2009 (class 0 OID 24613)
-- Dependencies: 175
-- Data for Name: consts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY consts (const_id, language_id, value, type) FROM stdin;
3	1	педиатр	spec                                                                                                
2	1	хирург	spec                                                                                                
4	1	специалист	degree                                                                                              
5	1	кандидат наук	degree                                                                                              
6	1	доктор наук	degree                                                                                              
1	1	терапе	spec                                                                                                
\.


--
-- TOC entry 2020 (class 0 OID 0)
-- Dependencies: 174
-- Name: consts_const_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('consts_const_id_seq', 1, true);


--
-- TOC entry 2007 (class 0 OID 24601)
-- Dependencies: 173
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY orders (order_id, first_name, last_name, patronymic, email, specialization, description, status, date, degree) FROM stdin;
1	Vasya	Pushkin	Aleksandrovich	admin@gmail.com	1	Description	0	2018-02-28	1
2	Vlad	Voropaev	Test	admin@mail.ru	1	Deesc	1	2018-02-28	1
\.


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 172
-- Name: orders_order_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('orders_order_id_seq', 1, true);


--
-- TOC entry 1896 (class 2606 OID 24619)
-- Name: consts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY consts
    ADD CONSTRAINT consts_pkey PRIMARY KEY (const_id);


--
-- TOC entry 1894 (class 2606 OID 24610)
-- Name: orders_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu; Tablespace: 
--

ALTER TABLE ONLY orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (order_id);


--
-- TOC entry 2016 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2018-03-01 08:01:29

--
-- PostgreSQL database dump complete
--

